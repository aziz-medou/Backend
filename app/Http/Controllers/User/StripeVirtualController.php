<?php

namespace App\Http\Controllers\User;

use App\Constants\GlobalConst;
use App\Constants\NotificationConst;
use App\Constants\PaymentGatewayConst;
use App\Http\Controllers\Controller;
use App\Http\Helpers\NotificationHelper;
use App\Http\Helpers\Response;
use App\Models\Admin\BasicSettings;
use App\Models\Admin\Currency;
use App\Models\Admin\TransactionSetting;
use App\Models\StripeVirtualCard;
use App\Models\Transaction;
use App\Models\UserNotification;
use App\Models\UserWallet;
use App\Models\VirtualCardApi;
use App\Notifications\Admin\ActivityNotification;
use App\Notifications\User\VirtualCard\CreateMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\PushNotificationHelper;
use App\Http\Helpers\TransactionLimit;
use App\Providers\Admin\BasicSettingsProvider;

class StripeVirtualController extends Controller
{
    protected $api;
    protected $card_limit;
    protected $basic_settings;
    protected $stripe_supported_currencies;

    public function __construct()
    {
        $cardApi = VirtualCardApi::first();
        $this->api =  $cardApi;
        $this->card_limit =  $cardApi->card_limit;
        $this->basic_settings = BasicSettingsProvider::get();
        $this->stripe_supported_currencies = [
            "currencies" => [
                "USD","GBP", "AED", "AFN", "ALL", "AMD", "AOA", "ARS", "AUD", "AWG",
                "AZN", "BAM", "BBD", "BDT", "BGN", "BIF", "BMD", "BND", "BOB", "BRL",
                "BSD", "BWP", "BYN", "BZD", "CAD", "CDF", "CHF", "CLP", "CNY",
                "NGN", "NIO", "NOK", "NPR", "NZD",
                "PAB", "PEN", "PGK", "PHP", "PKR", "PLN", "PYG", "QAR", "RON", "RSD",
                "RUB", "RWF", "SAR", "SBD", "SCR", "SEK", "SGD", "SHP", "SOS",
                "SRD", "STD", "THB", "TJS", "TOP", "TRY", "TTD", "TWD", "TZS",
                "UAH", "UGX", "UYU", "UZS", "VND", "VUV", "WST", "XAF", "XOF",
                "YER", "ZAR", "ZMW"
            ]
        ];
    }

    public function index()
    {
        $page_title = __("Virtual Card");
        $myCards = StripeVirtualCard::where('user_id',auth()->user()->id)->latest()->limit($this->card_limit)->get();
        $totalCards = StripeVirtualCard::where('user_id',auth()->user()->id)->count();
        $cardCharge = TransactionSetting::where('slug','virtual_card')->where('status',1)->first();
        $transactions = Transaction::auth()->virtualCard()->latest()->take(5)->get();
        $cardApi = $this->api;
        $from_wallets = UserWallet::auth()->whereHas('currency',function($q) {
            $q->where("status",GlobalConst::ACTIVE);
        })->active()->get();
        $supported_currency = support_currencies($this->stripe_supported_currencies['currencies']);
        return view('user.sections.virtual-card-stripe.index',compact(
            'page_title','myCards','cardApi',
            'transactions','cardCharge','totalCards',
            'from_wallets','supported_currency'
        ));
    }
    public function cardDetails($card_id)
    {
        $page_title = __('card Details');
        $myCard = StripeVirtualCard::where('card_id',$card_id)->first();
        $cardApi = $this->api;
        return view('user.sections.virtual-card-stripe.details',compact('page_title','myCard','cardApi'));
    }
    public function cardTransaction($card_id) {
        $page_title =__("Virtual Card Transaction");
        $user = auth()->user();
        $card = StripeVirtualCard::where('user_id',$user->id)->where('card_id', $card_id)->first();
        $card_truns =  getStripeCardTransactions($card->card_id);
        return view('user.sections.virtual-card-stripe.trx',compact('page_title','card','card_truns'));
    }
    public function cardBlockUnBlock(Request $request) {
        $validator = Validator::make($request->all(),[
            'status'                    => 'required|boolean',
            'data_target'               => 'required|string',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }
        $validated = $validator->safe()->all();
        if($request->status == 1 ){
            $card = StripeVirtualCard::where('id',$request->data_target)->where('status',1)->first();
            $status = 'inactive';
            if(!$card){
                $error = ['error' => [__('Something is wrong in your card')]];
                return Response::error($error,null,404);
            }
            $result = cardActiveInactive($card->card_id,$status);
            if(isset($result['status'])){
                if($result['status'] == true){
                    $card->status = false;
                    $card->save();
                    $success = ['success' => [__('Card Inactive Successfully')]];
                    return Response::success($success,null,200);
                }elseif($result['status'] == false){
                    $success = ['error' => [$result['message']??"Something is wrong"]];
                    return Response::success($success,null,200);
                }
            }
        }else{
        $card = StripeVirtualCard::where('id',$request->data_target)->where('status',0)->first();
        $status = 'active';
        if(!$card){
            $error = ['error' => [__('Something is wrong in your card')]];
            return Response::error($error,null,404);
        }
        $result = cardActiveInactive($card->card_id,$status);
        if(isset($result['status'])){
            if($result['status'] == true){
                $card->status = true;
                $card->save();
                $success = ['success' => [__('Card Active Successfully')]];
                return Response::success($success,null,200);
            }elseif($result['status'] == false){
                $success = ['error' => [$result['message']??"Something is wrong"]];
                return Response::success($success,null,200);
            }
        }

        }
    }
    public function makeDefaultOrRemove(Request $request) {
        $validated = Validator::make($request->all(),[
            'target'        => "required|numeric",
        ])->validate();
        $user = auth()->user();
        $targetCard =  StripeVirtualCard::where('id',$validated['target'])->where('user_id',$user->id)->first();
        $withOutTargetCards =  StripeVirtualCard::where('id','!=',$validated['target'])->where('user_id',$user->id)->get();
        try{
            $targetCard->update([
                'is_default'         => $targetCard->is_default ? 0 : 1,
            ]);
            if(isset(  $withOutTargetCards)){
                foreach(  $withOutTargetCards as $card){
                    $card->is_default = false;
                    $card->save();
                }
            }

        }catch(Exception $e) {
            return back()->with(['error' => [__("Something went wrong! Please try again.")]]);
        }
        return back()->with(['success' => [__('Status Updated Successfully!')]]);
    }
    public function createPage(){
        $page_title = __("Create Virtual Card");
        $supported_currency = support_currencies($this->stripe_supported_currencies['currencies']);
        $from_wallets = UserWallet::auth()->whereHas('currency',function($q) {
            $q->where("status",GlobalConst::ACTIVE);
        })->active()->get();
        $user       = userGuard()['user'];
        $cardCharge     = TransactionSetting::where('slug','virtual_card')->where('status',1)->first();

        return view('user.sections.virtual-card-stripe.create',compact('page_title','user','cardCharge','supported_currency','from_wallets'));
    }
    public function cardBuy(Request $request)
    {

        $validated = Validator::make($request->all(),[
            'card_amount'       => 'required|numeric|gt:0',
            'currency'          => "required|string|exists:currencies,code",
            'from_currency'     => "required|string|exists:currencies,code",
        ])->validate();

        $basic_setting = BasicSettings::first();
        $user = auth()->user();
        $amount = $request->card_amount;

        $wallet = UserWallet::where('user_id',$user->id)->whereHas("currency",function($q) use ($validated) {
            $q->where("code",$validated['from_currency'])->active();
        })->active()->first();
        if(!$wallet) return back()->with(['error' => [__('User wallet not found')]]);
        $card_currency = Currency::active()->where('code',$validated['currency'])->first();
        if(!$card_currency) return back()->with(['error' => [__('Card Currency Not Found')]]);

        $cardCharge = TransactionSetting::where('slug','virtual_card')->where('status',1)->first();
        $charges = $this->cardCharges($validated['card_amount'],$cardCharge,$wallet,$card_currency);

        $minLimit =  $cardCharge->min_limit *  $charges['card_currency_rate'];
        $maxLimit =  $cardCharge->max_limit *  $charges['card_currency_rate'];
        if($amount < $minLimit || $amount > $maxLimit)  return back()->with(['error' => [__("Please follow the transaction limit")]]);
        //daily and monthly
        try{
            (new TransactionLimit())->trxLimit('user_id',$wallet->user->id,PaymentGatewayConst::VIRTUALCARD,$wallet->currency,$amount,$cardCharge,PaymentGatewayConst::RECEIVED);
        }catch(Exception $e){
           $errorData = json_decode($e->getMessage(), true);
            return back()->with(['error' => [__($errorData['message'] ?? __("Something went wrong! Please try again."))]]);
        }
        if($charges['payable'] > $wallet->balance) return back()->with(['error' => [__("Your Wallet Balance Is Insufficient")]]);


        //create connected account
       if($user->stripe_connected_account == null){
        $c_account =  createConnectAccount($user);

        if( isset($c_account['status'])){
           if($c_account['status'] == false){
            return back()->with(['error' => [$c_account['message']]]);
           }
        }
        $stripe_connected_account_data =[
            'id' => $c_account['data']['id'],
            'object' => $c_account['data']['object'],
            'business_profile' => $c_account['data']['business_profile'],
            'business_type' => $c_account['data']['business_type'],
            'capabilities' => $c_account['data']['capabilities'],
            'charges_enabled' => $c_account['data']['charges_enabled'],
            'country' => $c_account['data']['country'],
            'created' => $c_account['data']['created'],
            'default_currency' => $c_account['data']['default_currency'],
            'details_submitted' => $c_account['data']['details_submitted'],
            'external_accounts' => $c_account['data']['external_accounts'],
            'future_requirements' => $c_account['data']['future_requirements'],
            'metadata' => $c_account['data']['metadata'],
            'payouts_enabled' => $c_account['data']['payouts_enabled'],
            'requirements' => $c_account['data']['requirements'],
            'settings' => $c_account['data']['settings'],
            'tos_acceptance' => $c_account['data']['tos_acceptance'],
            'type' => $c_account['data']['type'],

        ];
        $stripe_connected_account_data = (object)$stripe_connected_account_data;
        $user->stripe_connected_account = $stripe_connected_account_data;
        $user->save();
        $c_account = $user->stripe_connected_account->id;

       }else{
        $c_account = $user->stripe_connected_account->id;
       }


        //create card holder
       if( $user->stripe_card_holders == null){
        $card_holder =  createCardHolders($user,$c_account);
        if( isset($card_holder['status'])){
           if($card_holder['status'] == false){
            return back()->with(['error' => [$card_holder['message']]]);
           }
        }
        $stripe_card_holders_data =[
            'id' => $c_account['data']['id'],
        ];
        $stripe_card_holders_data = (object)$stripe_card_holders_data;

        $user->stripe_card_holders =   (object)$stripe_card_holders_data;
        $user->save();
        $card_holder_id = $user->stripe_card_holders->id;

       }else{
        $card_holder_id = $user->stripe_card_holders->id;
       }
       //create card now
       $created_card = createVirtualCard($card_holder_id,$c_account);
       if(isset($created_card['status'])){
            if($created_card['status'] == false){
                return back()->with(['error' => [$created_card['message']]]);
            }
       }
        //account update
        $account_update = updateAccount($c_account);
        if(isset($account_update['status'])){
            if($account_update['status'] == false){
                return back()->with(['error' => [$account_update['message']]]);
            }
        }

       //now funded amount
       $funded_amount = transfer($amount,$c_account);
       if(isset($funded_amount['status'])){
            if($funded_amount['status'] == false){
                return back()->with(['error' => [$funded_amount['message']]]);
            }
        }

       if($created_card['status']  = true){
            $card_info = (object)$created_card['data'];
            $v_card = new StripeVirtualCard();
            $v_card->user_id = $user->id;
            $v_card->name = $user->fullname;
            $v_card->card_id = $card_info->id;
            $v_card->type = $card_info->type;
            $v_card->brand = $card_info->brand;
            $v_card->currency = $card_info->currency;
            $v_card->amount = $amount;
            $v_card->charge = $charges['total_charge'];
            $v_card->maskedPan = "0000********".$card_info->last4;
            $v_card->last4 = $card_info->last4;
            $v_card->expiryMonth = $card_info->exp_month;
            $v_card->expiryYear = $card_info->exp_year;
            $v_card->status = true;
            $v_card->card_details = $card_info;
            $v_card->save();

            $trx_id =  'CB'.getTrxNum();
            try{
                $sender = $this->insertCardBuy($trx_id,$user,$wallet,$amount, $v_card,$charges);
                $this->insertBuyCardCharge($charges,$user,$sender,$v_card->maskedPan);
                if( $basic_setting->email_notification == true){
                    $notifyDataSender = [
                        'trx_id'            => $trx_id,
                        'title'             => __("Virtual Card (Buy Card)"),
                        'request_amount'    => get_amount($amount,$charges['card_currency'],$charges['precision_digit']),
                        'payable'           => get_amount($charges['payable'],$charges['from_currency'],$charges['precision_digit']),
                        'charges'           => get_amount( $charges['total_charge'],$charges['from_currency'],$charges['precision_digit']),
                        'card_amount'       => get_amount($amount,$charges['card_currency'],$charges['precision_digit']),
                        'card_pan'          => $v_card->maskedPan,
                        'status'            => __("success"),
                      ];
                      try{
                          $user->notify(new CreateMail($user,(object)$notifyDataSender));
                      }catch(Exception $e){}
                }
                if( $basic_setting->sms_notification == true){
                    try{
                        sendSms($user,'VIRTUAL_CARD_BUY',[
                            'request_amount'    => get_amount($amount,$charges['card_currency'],$charges['precision_digit']),
                            'card_amount'       => get_amount($amount,$charges['card_currency'],$charges['precision_digit']),
                            'card_pan'          => $v_card->maskedPan,
                            'trx'               => $trx_id,
                            'time'              => now()->format('Y-m-d h:i:s A')
                        ]);
                    }catch(Exception $e) {}
                }
            //admin notification
            $this->adminNotification($trx_id,$charges,$amount,$user,$v_card);
                return redirect()->route("user.stripe.virtual.card.index")->with(['success' => [__('Virtual Card Buy Successfully')]]);
            }catch(Exception $e){
                return back()->with(['error' => [__("Something went wrong! Please try again.")]]);
            }

       }

    }
    public function getSensitiveData(Request $request){
        $card_id = $request->card_id;
        $data['result'] = getSensitiveData( $card_id);
        return response()->json($data);
    }
     //card buy helper
     public function insertCardBuy($trx_id,$user,$wallet,$amount,$v_card,$charges) {
        $trx_id = $trx_id;
        $authWallet = $wallet;
        $afterCharge = ($authWallet->balance - $charges['payable']);
        $details =[
            'card_info' =>   $myCard??'',
            'charges'   =>   $charges,
        ];
        DB::beginTransaction();
        try{
            $id = DB::table("transactions")->insertGetId([
                'user_id'                       => $user->id,
                'user_wallet_id'                => $authWallet->id,
                'payment_gateway_currency_id'   => null,
                'type'                          => PaymentGatewayConst::VIRTUALCARD,
                'trx_id'                        => $trx_id,
                'request_amount'                => $amount,
                'payable'                       => $charges['payable'],
                'available_balance'             => $afterCharge,
                'remark'                        => PaymentGatewayConst::CARDBUY,
                'details'                       => json_encode($details),
                'attribute'                      =>PaymentGatewayConst::RECEIVED,
                'status'                        => true,
                'created_at'                    => now(),
            ]);
            $this->updateSenderWalletBalance($authWallet,$afterCharge);

            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            throw new Exception(__("Something went wrong! Please try again."));
        }
        return $id;
    }

    public function insertBuyCardCharge($charges,$user,$id,$masked_card) {
        DB::beginTransaction();
        try{
            DB::table('transaction_charges')->insert([
                'transaction_id'    => $id,
                'percent_charge'    => $charges['percent_charge'],
                'fixed_charge'      => $charges['fixed_charge'],
                'total_charge'      => $charges['total_charge'],
                'created_at'        => now(),
            ]);
            DB::commit();

            //notification
            $notification_content = [
                'title'         =>__('buy Card'),
                'message'       => __('Buy card successful')." ".$masked_card,
                'image'         => files_asset_path('profile-default'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::CARD_BUY,
                'user_id'  => $user->id,
                'message'   => $notification_content,
            ]);
            //Push Notifications
            if( $this->basic_settings->push_notification == true){
                try{
                        (new PushNotificationHelper())->prepare([$user->id],[
                            'title' => $notification_content['title'],
                            'desc'  => $notification_content['message'],
                            'user_type' => 'user',
                        ])->send();
                }catch(Exception $e) {}
            }
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            throw new Exception(__("Something went wrong! Please try again."));
        }
    }
    //update user balance
    public function updateSenderWalletBalance($authWallet,$afterCharge) {
        $authWallet->update([
            'balance'   => $afterCharge,
        ]);
    }
    //admin notification
    public function adminNotification($trx_id,$charges,$amount,$user,$v_card){
        $notification_content = [
            //email notification
            'subject' => __("Virtual Card (Buy Card)"),
            'greeting' => __("Virtual Card Information"),
            'email_content' =>__("web_trx_id")." : ".$trx_id."<br>".__("request Amount")." : ".get_amount($amount,$charges['card_currency'],$charges['precision_digit'])."<br>".__("Fees & Charges")." : ".get_amount($charges['total_charge'],$charges['from_currency'],$charges['precision_digit'])."<br>".__("Total Payable Amount")." : ".get_amount($charges['payable'],$charges['from_currency'],$charges['precision_digit'])."<br>".__("card Masked")." : ".@$v_card->maskedPan."<br>".__("Status")." : ".__("success"),

            //push notification
            'push_title' => __("Virtual Card (Buy Card)")." (".userGuard()['type'].")",
            'push_content' => __('web_trx_id')." : ".$trx_id." ".__("request Amount")." : ".get_amount($amount,$charges['card_currency'],$charges['precision_digit'])." ".__("card Masked")." : ".$v_card->maskedPan??"",

            //admin db notification
            'notification_type' =>  NotificationConst::CARD_BUY,
            'admin_db_title' => "Virtual Card Buy"." (".userGuard()['type'].")",
            'admin_db_message' => "Transaction ID"." : ".$trx_id.",".__("Request Amount")." : ".get_amount($amount,$charges['card_currency'],$charges['precision_digit']).","."Card Masked"." : ".@$v_card->maskedPan." (".$user->email.")",
        ];

        try{
            //notification
            (new NotificationHelper())->admin(['admin.virtual.card.logs','admin.virtual.card.export.data'])
                                    ->mail(ActivityNotification::class, [
                                        'subject'   => $notification_content['subject'],
                                        'greeting'  => $notification_content['greeting'],
                                        'content'   => $notification_content['email_content'],
                                    ])
                                    ->push([
                                        'user_type' => "admin",
                                        'title' => $notification_content['push_title'],
                                        'desc'  => $notification_content['push_content'],
                                    ])
                                    ->adminDbContent([
                                        'type' => $notification_content['notification_type'],
                                        'title' => $notification_content['admin_db_title'],
                                        'message'  => $notification_content['admin_db_message'],
                                    ])
                                    ->send();


        }catch(Exception $e) {}

    }

    //card buy charges function
    public function cardCharges($amount,$charges,$wallet,$card_currency){
        $sPrecision = get_wallet_precision($wallet->currency);
        $exchange_rate = $wallet->currency->rate/$card_currency->rate;

        $data['exchange_rate']         = $exchange_rate;
        $data['card_amount']           = $amount;
        $data['card_currency']         = $card_currency->code;
        $data['card_currency_rate']    = $card_currency->rate;

        $data['from_amount']           = $amount * $exchange_rate;
        $data['from_currency']         = $wallet->currency->code;
        $data['from_currency_rate']    = $wallet->currency->rate;

        $data['percent_charge']        = ($data['from_amount'] / 100) * $charges->percent_charge ?? 0;
        $data['fixed_charge']          = $exchange_rate * $charges->fixed_charge ?? 0;
        $data['total_charge']          = $data['percent_charge'] + $data['fixed_charge'];
        $data['from_wallet_balance']   = $wallet->balance;
        $data['payable']               = $data['from_amount'] + $data['total_charge'];
        $data['card_platform']         = "Stripe Card";
        $data['precision_digit']       = $sPrecision;

        return $data;

    }
}
