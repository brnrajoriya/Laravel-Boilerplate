<?php

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
	        [
                'name' => 'Chevrolet'
            ],
            [
	            'name' => 'Datsun'
            ],
            [
	            'name' => 'Ford'
            ],
            [
	            'name' => 'Honda'
            ],
            [
	            'name' => 'Hyundai'
            ]
	    ];
	    
        foreach ($brands as $key => $brand) {
            Brand::firstOrCreate($brand);
        }
    }
}
