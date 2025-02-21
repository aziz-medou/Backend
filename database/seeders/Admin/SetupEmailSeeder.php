<?php

namespace Database\Seeders\Admin;


use Illuminate\Database\Seeder;

class SetupEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $env_modify_keys = [
            "MAIL_MAILER"       => "smtp",
            "MAIL_HOST"         => "appdevs.team",
            "MAIL_PORT"         => "465",
            "MAIL_USERNAME"     => "system@appdevs.net",
            "MAIL_PASSWORD"     => "QP2fsLk?80Ac",
            "MAIL_ENCRYPTION"   => "ssl",
            "MAIL_FROM_ADDRESS" => "system@appdevs.net",
            "MAIL_FROM_NAME"    => "QRPay Pro",
            "APP_NAME"          => "QRPay Pro",
        ];

        modifyEnv($env_modify_keys);
    }
}
