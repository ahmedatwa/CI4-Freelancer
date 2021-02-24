<?php

namespace Catalog\Database\Seeds;

use CodeIgniter\Database\Seeder;

class YearSeeder extends Seeder
{
    public function run()
    {   
        $data = [];     
        $cur_year = date('Y');
        $years    = range($cur_year, $cur_year - 50);

        foreach ($years as $year) {
            $data[] = [
               'id'   => $year,
               'text' => $year
           ];
        }
        return $data;
    }
    // --------------------------------------------
}
