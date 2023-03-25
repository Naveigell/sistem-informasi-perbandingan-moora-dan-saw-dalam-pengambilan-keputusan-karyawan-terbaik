<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeSubCriteria;
use App\Models\SubCriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class EmployeeSubCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subCriterias = SubCriteria::all()->groupBy('criteria_id');
        $employees    = Employee::all();
        $data = [];

        foreach ($employees as $employee) {
            foreach ($subCriterias as $subCriteria) {

                $sub = $subCriteria->random();

                $data[] = [
                    "employee_id" => $employee->id,
                    "sub_criteria_id" => $sub->id,
                    "criteria_id" => $sub->criteria_id,
                    "created_at" => now()->toDateTimeString(),
                    "updated_at" => now()->toDateTimeString(),
                ];
            }
        }

        EmployeeSubCriteria::insert($data);
    }
}
