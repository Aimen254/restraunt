<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TablesTableSeeder extends Seeder
{
    public function run()
    {
        $tables = [
            ['name' => 'Table 1', 'capacity' => 2, 'position' => 'Window'],
            ['name' => 'Table 2', 'capacity' => 2, 'position' => 'Window'],
            ['name' => 'Table 3', 'capacity' => 4, 'position' => 'Center'],
            ['name' => 'Table 4', 'capacity' => 4, 'position' => 'Center'],
            ['name' => 'Table 5', 'capacity' => 6, 'position' => 'Patio'],
            ['name' => 'Table 6', 'capacity' => 6, 'position' => 'Patio'],
            ['name' => 'Table 7', 'capacity' => 8, 'position' => 'Private Room'],
        ];

        foreach ($tables as $table) {
            Table::create([
                'name' => $table['name'],
                'capacity' => $table['capacity'],
                'position' => $table['position'],
                'is_available' => true,
            ]);
        }
    }
}