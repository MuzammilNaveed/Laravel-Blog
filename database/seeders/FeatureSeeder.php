<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;          

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        $features = array(
            array("id" => 1 , "title" => 'Dashboard',"slug" => 'dashboard', "sequence" => 1,"role_id" => 1, "is_active" => 1 , "parent_id" => 0, "route" => "dashboard.index"),
        );

    }
}
