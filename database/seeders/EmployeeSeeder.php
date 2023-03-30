<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\Employee;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
        // "sub_criterias" -> the key is index of criteria and the value is the value of sub criteria, that's what you
        // need
        $employees = [
            [
                "name" => "Komang Dewi Indraswari",
                "email" => $faker->unique()->email,
                "phone" => $faker->unique()->numerify('08##########'),
                "address" => $faker->address,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    1 => 4,
                    2 => 3,
                    3 => 3,
                    4 => 4,
                    5 => 3,
                    6 => 2,
                ]
            ],
            [
                "name" => "I Ketut Putra",
                "email" => $faker->unique()->email,
                "phone" => $faker->unique()->numerify('08##########'),
                "address" => $faker->address,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    1 => 3,
                    2 => 2,
                    3 => 2,
                    4 => 4,
                    5 => 2,
                    6 => 4,
                ]
            ],
            [
                "name" => "Ni Kadek Devi Yanti",
                "email" => $faker->unique()->email,
                "phone" => $faker->unique()->numerify('08##########'),
                "address" => $faker->address,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    1 => 4,
                    2 => 4,
                    3 => 3,
                    4 => 3,
                    5 => 1,
                    6 => 2,
                ]
            ],
            [
                "name" => "Ni Ketut Suarmini",
                "email" => $faker->unique()->email,
                "phone" => $faker->unique()->numerify('08##########'),
                "address" => $faker->address,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    1 => 3,
                    2 => 2,
                    3 => 3,
                    4 => 2,
                    5 => 1,
                    6 => 4,
                ]
            ],
            [
                "name" => "Ida Bagus Putra Manuaba",
                "email" => $faker->unique()->email,
                "phone" => $faker->unique()->numerify('08##########'),
                "address" => $faker->address,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
                "sub_criterias" => [
                    1 => 2,
                    2 => 4,
                    3 => 2,
                    4 => 1,
                    5 => 3,
                    6 => 4,
                ]
            ],
        ];

        $criterias = Criteria::with('subCriterias')->get();

        foreach ($employees as $employee) {
            DB::transaction(function () use ($employee, $criterias) {
                $model = Employee::create(Arr::except($employee, ['sub_criterias']));

                foreach ($criterias as $index => $criteria) {
                    // find the sub criteria with value = ?
                    $subCriteria = $criteria->subCriterias->where('value', $employee['sub_criterias'][$index + 1])->first();

                    // and create sub criteria by that model
                    $model->subCriterias()->create([
                        "sub_criteria_id" => $subCriteria->id,
                        "criteria_id" => $subCriteria->criteria_id,
                    ]);
                }
            });
        }
    }
}
