<?php

namespace Database\Seeders;

use App\Models\Employee;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        $employees = [];

        foreach (range(1, 10) as $item) {
            $employees[] = [
                "name" => $faker->name,
                "email" => $faker->unique()->email,
                "phone" => $faker->unique()->numerify('08##########'),
                "address" => $faker->address,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
            ];
        }

        Employee::insert($employees);
    }
}
