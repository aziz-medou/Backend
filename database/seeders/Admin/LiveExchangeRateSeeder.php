<?php

namespace Database\Seeders\Admin;

use App\Models\LiveExchangeRateApiSetting;
use Illuminate\Database\Seeder;

class LiveExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $live_exchange_rate_api_settings = array(
            array('slug' => 'CURRENCY-LAYER','provider' => 'Currency Layer','value' => '{"access_key":"5fec442d27f34a1c71eed0fce252a16d","base_url":"https:\\/\\/api.currencylayer.com","multiply_by":"1"}','multiply_by' => '1.00000000','currency_module' => '1','payment_gateway_module' => '1','status' => '1','created_at' => now(),'updated_at' => now())
        );

        LiveExchangeRateApiSetting::insert($live_exchange_rate_api_settings);
    }
}
