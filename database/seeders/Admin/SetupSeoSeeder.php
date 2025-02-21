<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\SetupSeo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetupSeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setup_seos = array(
            array('id' => '1','slug' => 'qrpay','title' => 'QRPay Pro - Money Transfer with QR Code','desc' => 'QRPay Pro offers a comprehensive solution for seamless money transfers using QR codes, catering to Android and iOS platforms, along with a user-friendly website and efficient admin panels. The system comprises three distinct interfaces: User Panel, Agent Panel, Merchant Panel, and Super Admin Panel. Key features encompass effortless money transfers through QR codes, swift payment processing, mobile top-up services, bill payment functionalities, streamlined remittance solutions, virtual card options, a secure payment checkout page, versatile payment gateway integration, and an accessible Developer API. Our commitment is in delivering exceptional software solutions at a budget-friendly cost, empowering you to capitalize on opportunities and excel in this dynamic industry. Embrace the opportunity to elevate ordinary operations into extraordinary accomplishments with QRPay Pro.','tags' => '["agent","contactless payment","developer api","digital wallet","ewallet","flutter app","gateway solutions","merchant api","mobile wallet","money transfer","payment gateway","qr code money transfer","qr code payment","qr code wallet","QRPay Pro"]','image' => '1d1da218-2b43-44a3-a4e4-39ff3dba94c3.webp','last_edit_by' => '1','created_at' => now(),'updated_at' => now())
        );

        SetupSeo::insert($setup_seos);
    }
}
