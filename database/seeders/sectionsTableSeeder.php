<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
use App\Models\section;

class sectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sectionRecords = [
            ['id'=>1,'name'=>'Men','status'=>1],
            ['id'=>2,'name'=>'Women','status'=>1],
            ['id'=>3,'name'=>'Kids','status'=>1],
        ];

        section::insert($sectionRecords);
    }
}
