<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Category_type=['عينية','مستحضرات تجميلية ','فيتامينات',"التهابات"];
        for($i=0;$i<4 ;$i++ ) {
            Category::query()->create([
                'name' => $Category_type[$i],
            ]);
        }
    }
}
