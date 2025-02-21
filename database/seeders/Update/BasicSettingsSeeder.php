<?php

namespace Database\Seeders\Update;

use App\Models\Admin\BasicSettings;
use Exception;
use Illuminate\Database\Seeder;

class BasicSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        $basicSettings = BasicSettings::first();
        if($basicSettings->sms_config == null || $basicSettings->sms_config == ''){
            $sms_config =  [
                'account_sid' => 'AC1218888d1aba3d6ac3bebced6da33ec4',
                'auth_token' => 'd2f9bacfb7500854fe7d4f93e38d52f2',
                'from' => '+17623394434',
                'name' => 'twilio',
            ];
        }else{
            $sms_config = $basicSettings->sms_config;
        }

        $data = [
            'web_version'   => "1.1.0",
            'sms_config'    => $sms_config,
            'sms_api'       => "Hi {{name}}, {{message}}",
        ];
        $basicSettings->update($data);

        // //update language values
        // try{
        //     update_project_localization_data();
        // }catch(Exception $e) {
        //     // handle error
        // }
    }
}
