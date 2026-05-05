<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Products',
                'children' => [
                    ['name' => 'Electronics'],
                    ['name' => 'Clothing'],
                    ['name' => 'Furniture'],
                ]
            ],
            [
                'name' => 'Services',
                'children' => [
                    ['name' => 'Consulting'],
                    ['name' => 'Maintenance'],
                ]
            ],
            [
                'name' => 'Accounts',
                'children' => [
                    ['name' => 'Income'],
                    ['name' => 'Expense'],
                ]
            ],
        ];

        foreach ($data as $parent) {
            $parentCategory = Category::create([
                'name' => $parent['name'],
                'slug' => Str::slug($parent['name']),
            ]);

            foreach ($parent['children'] as $child) {
                Category::create([
                    'name' => $child['name'],
                    'slug' => Str::slug($child['name']),
                    'parent_id' => $parentCategory->id
                ]);
            }
        }
    }
}
