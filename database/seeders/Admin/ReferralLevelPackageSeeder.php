<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Seeder;
use App\Models\ReferralLevelPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReferralLevelPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $referral_level_packages = array(
            array('title' => 'Level 1','refer_user' => '0','deposit_amount' => '0','commission' => '1.00000000','default' => '1','created_at' => now(),'updated_at' => now()),
            array('title' => 'Level 2','refer_user' => '5','deposit_amount' => '100','commission' => '2','default' => '0','created_at' => now(),'updated_at' => now()),
            array('title' => 'Level 3','refer_user' => '10','deposit_amount' => '500','commission' => '3','default' => '0','created_at' => now(),'updated_at' => now()),
            array('title' => 'Level 4','refer_user' => '30','deposit_amount' => '1000','commission' => '5','default' => '0','created_at' => now(),'updated_at' => now()),
            array('title' => 'Level 5','refer_user' => '50','deposit_amount' => '5000','commission' => '10','default' => '0','created_at' => now(),'updated_at' => now()),
            array('title' => 'Level 6','refer_user' => '100','deposit_amount' => '10000','commission' => '50','default' => '0','created_at' => now(),'updated_at' => now()),
        );

        ReferralLevelPackage::upsert($referral_level_packages,['id'],[]);
    }
}
