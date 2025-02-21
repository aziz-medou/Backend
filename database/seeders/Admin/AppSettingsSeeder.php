<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AppSettings;
use Illuminate\Database\Seeder;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app_settings = array(
            array('id' => '1','version' => '1.1.0','splash_screen_image' => 'seeder/splash_screen.png','url_title' => 'Our App Url','android_url' => 'https://play.google.com','iso_url' => 'https://www.apple.com/store','agent_version' => '1.1.0','merchant_version' => '1.1.0','agent_splash_screen_image' => 'seeder/agent/splash_screen.webp',
            'merchant_splash_screen_image' => 'seeder/merchant/splash_screen.webp','created_at' => now(),'updated_at' => now())
          );

        AppSettings::truncate();
        AppSettings::insert($app_settings);
    }
}
