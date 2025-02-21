<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\SmsTemplate;
use Illuminate\Database\Seeder;

class SmsTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sms_templates = array(
            array('act' => 'PASS_RESET_CODE','name' => 'Password Reset','subj' => 'Password Reset','sms_body' => 'Your account recovery code is: {{code}}','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'PASS_RESET_DONE','name' => 'Password Reset Confirmation','subj' => 'You have Reset your password','sms_body' => 'Your password has been changed successfully','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'EVER_CODE','name' => 'Email Verification','subj' => 'Please verify your email address','sms_body' => 'Your email verification code is: {{code}}','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'SVER_CODE','name' => 'SMS Verification ','subj' => 'Please verify your phone','sms_body' => 'Your phone verification code is: {{code}}','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'ADD_MONEY_COMPLETE','name' => 'Automated Add Money- Successful','subj' => 'Add money Completed Successfully','sms_body' => '{{amount}} {{currency}} Add Money successfully by {{gateway_name}}','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'ADD_MONEY_REQUEST','name' => 'Manual Add Money- User Requested','subj' => 'Add money Request Submitted Successfully','sms_body' => '{{amount}} Add Money requested by {{method}}. Charge: {{charge}} . Trx: {{trx}}
                                ','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'ADD_MONEY_APPROVE','name' => 'Manual Add Money - Admin Approved','subj' => 'Your Add Money is Approved','sms_body' => 'Admin Approve Your {{amount}} add money request by {{gateway_name}} TrxId: {{trx}}','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'ADD_MONEY_REJECT','name' => 'Manual Add Money- Admin Rejected','subj' => 'Your Add Money Request is Rejected','sms_body' => 'Admin Rejected Your {{amount}} add money request by {{gateway_name}},Rejection Reason: {{rejection_message}},TrxId: {{trx}}','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'WITHDRAW_REQUEST','name' => 'Withdraw - User Requested','subj' => 'Withdraw Request Submitted Successfully','sms_body' => 'Withdraw Money: {{amount}} withdraw requested by {{method_name}}, Method Currency {{currency}}. You will get {{will_get}}. Trx {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'WITHDRAW_REJECT','name' => 'Withdraw - Admin Rejected','subj' => 'Withdraw Request has been Rejected and your money is refunded to your account','sms_body' => 'Admin Rejected Your {{amount}} withdraw request by {{method}}. Transaction {{trx}},Rejection Reason: {{reject_reason}}, Rejected At: {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'WITHDRAW_APPROVE','name' => 'Withdraw - Admin Approved','subj' => 'Withdraw Request has been Processed and your money is sent','sms_body' => 'Admin Approve Your {{amount}} withdraw request by {{method}}. Transaction {{trx}}, Approved At: {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'BAL_ADD','name' => 'Balance Add by Admin','subj' => 'Your Account has been Credited','sms_body' => '{{amount}} {{currency}} credited in your account. Your Current Balance {{remaining_balance}} {{currency}} . Transaction: #{{trx}}','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'BAL_SUB','name' => 'Balance Subtracted by Admin','subj' => 'Your Account has been Debited','sms_body' => '{{amount}} {{currency}} debited from your account. Your Current Balance {{remaining_balance}} {{currency}} . Transaction: #{{trx}}','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'MONEY_OUT','name' => 'Money Out','subj' => 'Money Out','sms_body' => 'Money Out  {{amount}} to {{agent}} successful. Charge {{charge}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'MONEY_OUT_TO_AGENT','name' => 'Money Out To Agent','subj' => 'Money Out','sms_body' => 'Money Out  {{amount}} from {{user}} successful.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'MAKE_PAYMENT','name' => 'Make Payment','subj' => 'Make Payment','sms_body' => 'Make Payment To: {{to_user}}, Amount: {{amount}} Successful.Charge {{charge}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'MAKE_PAYMENT_MERCHANT','name' => 'Make Payment','subj' => 'Make Payment','sms_body' => 'Make Payment From: {{from_user}}, Amount: {{amount}} Successful.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'EXCHANGE_MONEY','name' => 'Exchange Money','subj' => 'Exchange Money','sms_body' => 'Exchanged {{from_wallet_amount}} {{from_wallet_curr}} from wallet ( {{from_wallet_curr}} ) To wallet ( {{to_wallet_curr}} ) successful.Exchanged amount : {{to_wallet_amount}} {{to_wallet_curr}}. Remaining balance of  ( {{from_wallet_curr}} ) is : {{from_balance}} {{from_wallet_curr}} New balance of  ( {{to_wallet_curr}} ) is : {{to_balance}}  {{to_wallet_curr}} TrxID : {{trx}}Time :  {{time}}','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'SEND_MONEY','name' => 'Send Money','subj' => 'Send Money','sms_body' => 'Send Money {{amount}} to {{to_user}} successful.Charge {{charge}},Remaining Balance {{balance}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'SEND_MONEY_RECEIVE','name' => 'Send Money From','subj' => 'Send Money From','sms_body' => 'Receive Money {{amount}} from {{from_user}} successful.Remaining Balance {{balance}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'RECEIVED_MONEY','name' => 'Received Money','subj' => 'Received Money','sms_body' => 'Received Money {{amount}} from {{from_user}} successful.Remaining Balance {{balance}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'REQUEST_MONEY','name' => 'Request Money','subj' => 'Request Money','sms_body' => 'Money Request {{amount}} to {{receiver}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'REQUEST_MONEY_RECEIVER','name' => 'Request Money','subj' => 'Request Money','sms_body' => 'Money Request {{amount}} from {{requestor}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            // array('act' => 'REJECT_REQUEST_MONEY','name' => 'Reject Request Money','subj' => 'Reject Request Money','sms_body' => 'Money Request {{amount}} is rejected.TrxID {{trx}}  at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => '2021-06-30 17:03:02'),

            // array('act' => 'ACCEPT_REQUEST_MONEY','name' => 'Accept Request Money','subj' => 'Accept Request Money','sms_body' => 'Request Money {{amount}} is accepted.TrxID {{trx}} at {{time}}','sms_status' => '1','created_at' => now(),'updated_at' => '2021-06-30 16:50:39'),

            array('act' => 'MONEY_IN','name' => 'Money In','subj' => 'Money In','sms_body' => 'Money In {{amount}} from {{agent}} Successful.Your New Balance {{balance}}. TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'MONEY_IN_AGENT','name' => 'Money In Agent','subj' => 'Money In','sms_body' => 'Money In {{amount}} To {{user}} Successful. Total Charge: {{charge}}, Payable: {{payable}}. Your New Balance Is {{balance}}. TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'BILL_PAY','name' => 'Bill Pay','subj' => 'Bill Pay Request Send Successful','sms_body' => 'Bill Pay: {{amount}},Pay Type: {{type}}, Bill Type: {{bill_type}}, Bill Number: {{bill_number}},Billing Month: {{month}} Successful.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'MOBILE_TOPUP','name' => 'Mobile Top Up Request','subj' => 'Mobile Top Up Request Sent Successfully','sms_body' => 'Mobile TopUp: {{amount}}, Operator Name: {{name}}, Mobile Number: {{mobile_number}} Charge: {{charge}}, Payable: {{payable}} Successful. TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'VIRTUAL_CARD_BUY','name' => 'Virtual Card Buy','subj' => 'Virtual Card Buy Successfully','sms_body' => 'Virtual Card Buy Successfully, Request Amount: {{request_amount}}, Card Amount: {{card_amount}}, Card Pan: {{card_pan}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'VIRTUAL_CARD_FUND','name' => 'Virtual Card Fund','subj' => 'Virtual Card Fund Successfully','sms_body' => 'Virtual Card Fund Successfully, Fund Amount: {{request_amount}}, Card Amount: {{card_amount}}, Card Pan: {{card_pan}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'SEND_REMITTANCE','name' => 'Send Remittance','subj' => 'Send Remittance Successfully','sms_body' => 'Send Remittance: From Country: {{form_country}}, To Country: {{to_country}}, Transaction Type: {{transaction_type}}, Recipient: {{recipient}}, Send Amount: {{send_amount}},Recipient Get: {{recipient_amount}}  successful. Remaining Balance {{balance}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'SEND_REMITTANCE_AGENT','name' => 'Send Remittance','subj' => 'Send Remittance Successfully','sms_body' => 'Send Remittance: From Country: {{form_country}}, To Country: {{to_country}}, Transaction Type: {{transaction_type}}, Sender Recipient: {{sender_recipient}}, Receiver Recipient: {{receiver_recipient}} Send Amount: {{send_amount}},Recipient Get: {{recipient_amount}}  successful. Remaining Balance {{balance}}.TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'KYC_APPROVED','name' => 'KYC Approved','subj' => 'KYC Approved Successfully','sms_body' => 'Your KYC verification request is approved by admin. Approved At {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'KYC_REJECTED','name' => 'KYC Rejected','subj' => 'KYC Rejected Successfully','sms_body' => 'Your KYC verification request is rejected by admin. Rejection Reason {{reason}}, Rejected At {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'BILL_PAY_APPROVED','name' => 'Bill Pay Approved','subj' => 'Bill Pay Approved Successfully','sms_body' => 'Bill Pay Approved Successfully. Amount: {{amount}},Pay Type: {{type}}, Bill Type: {{bill_type}}, Bill Number: {{bill_number}}, Billing Month: {{month}}.TrxID: {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'BILL_PAY_REJECTED','name' => 'Bill Pay Rejected','subj' => 'Bill Pay Rejected Successfully','sms_body' => 'Bill Pay Rejected Amount: {{amount}},Pay Type: {{type}}, Bill Type: {{bill_type}}, Bill Number: {{bill_number}}, Billing Month: {{month}}.TrxID: {{trx}}, Rejected Reason: {{reason}}, at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'MOBILE_TOPUP_APPROVED','name' => 'Mobile TopUp Approved','subj' => 'Mobile TopUp Approved Successfully','sms_body' => 'Mobile TopUp Approved  Amount:  {{amount}}, TopUp Type: {{topup_type}}, Mobile Number: {{mobile_number}}.TrxID {{trx}} at {{time}}.
                      ','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'MOBILE_TOPUP_REJECTED','name' => 'Mobile TopUp Rejected','subj' => 'Mobile TopUp Rejected Successfully','sms_body' => 'Mobile TopUp Rejected  Amount:  {{amount}}, TopUp Type: {{topup_type}}, Mobile Number: {{mobile_number}}, Remaining Balance: {{balance}}.TrxID {{trx}}, Rejected Reason:{{reason}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'REMITTANCE_APPROVED','name' => 'Send Remittance Approved','subj' => 'Send Remittance Approved Successfully','sms_body' => 'Send Remittance Approved  From Country: {{form_country}}, To Country: {{to_country}}, Transaction Type: {{transaction_type}}, Recipient: {{recipient}}, Send Amount: {{send_amount}},Recipient Get: {{recipient_amount}} , TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'REMITTANCE_REJECTED','name' => 'Send Remittance Rejected','subj' => 'Send Remittance Rejected Successfully','sms_body' => 'Send Remittance Rejected  From Country: {{form_country}}, To Country: {{to_country}}, Transaction Type: {{transaction_type}}, Recipient: {{recipient}}, Send Amount: {{send_amount}},Recipient Get: {{recipient_amount}}, Remaining Balance {{balance}}.TrxID: {{trx}},  Rejected  Reason: {{reason}} at {{time}}.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'GIFT_CARD','name' => 'Gift Card Order','subj' => 'Gift Card','sms_body' => 'Gift Card Order Successful. Gift Card Title: {{title}} Card Unit Price:{{unit_price}} Card Quantity: {{qty}} Card Total Price:{{card_total_price}} Total Charge: {{charge}} Total Payable:{{payable}}. TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' =>now(),'updated_at' => now()),

            array('act' => 'PAYMENT_LINK_USER','name' => 'Payment Link','subj' => 'Payment Link Success','sms_body' => 'Payment Link Successfully. Request Amount: {{request_amount}}, Charge: {{total_charge}}, Will Get: {{will_pay}}. TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' =>now(),'updated_at' => now()),

            array('act' => 'PAYMENT_LINK_BUYER','name' => 'Payment Link','subj' => 'Payment Link Success','sms_body' => 'Payment Link Successfully. Request Amount: {{request_amount}}, TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' =>now(),'updated_at' => now()),

            array('act' => 'PAYMENT_LINK_SENDER','name' => 'Payment Link','subj' => 'Payment Link Success','sms_body' => 'Payment Link Successfully. Request Amount: {{request_amount}}, Charge: {{total_charge}}, Payable: {{payable}}. TrxID {{trx}} at {{time}}.','sms_status' => '1','created_at' =>now(),'updated_at' => now()),

            array('act' => 'REGISTRATION_BONUS','name' => 'Registration Bonus','subj' => 'Registration Bonus','sms_body' => 'Congratulations! You got the registration bonus {{amount}} At {{time}}.Now you can deposit and earn more.','sms_status' => '1','created_at' => now(),'updated_at' => now()),

            array('act' => 'MONEY_EXCHANGE','name' => 'Money Exchange','subj' => 'Money Exchange','sms_body' => 'Congratulations! Your Money Exchange Request Successful. Exchange From: {{from_amount}} To {{to_amount}}. TRX ID {{trx}} At {{time}} .','sms_status' => '1','created_at' => now(),'updated_at' => now())
        );

          SmsTemplate::insert($sms_templates);
    }
}
