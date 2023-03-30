<?php

namespace App\Services;

use App\Libraries\DecisionSupportSystem;
use App\Libraries\Moora;
use App\Libraries\SimpleAdditiveWeighting;
use App\Models\Employee;
use Illuminate\Support\Collection;

class CalculationService extends DecisionSupportSystemBaseService
{
    /**
     * The generator of simple additive weighting
     *
     * @param Collection $criterias
     * @param Collection $employeeSubCriterias
     * @return mixed
     * @throws \Exception
     */
    public function simpleAdditiveWeighting(Collection $criterias, Collection $employeeSubCriterias)
    {
        $simpleAdditiveWeighting = new SimpleAdditiveWeighting();
        $simpleAdditiveWeighting->setPrecision(2);

        $employeeIds = null;

        $this->addDatas($simpleAdditiveWeighting, $criterias, $employeeSubCriterias, $employeeIds);

        $simpleAdditiveWeighting->normalize();
        $simpleAdditiveWeighting->calculate();

        // we're combining the employees ids as a key and the SAW result as a values
        $employeeSimpleAdditiveWeightingResult = collect(
            array_combine(
                $employeeIds->toArray(),
                $simpleAdditiveWeighting->getResult()
            )
        );

        $employees = Employee::whereIn('id', $employeeSimpleAdditiveWeightingResult->keys())
            ->get()
            ->map(function ($employee) use ($employeeSimpleAdditiveWeightingResult) {

                // we must be found the key of employee id
                $keys = $employeeSimpleAdditiveWeightingResult->keys()->toArray();
                $index = $keys[array_search($employee->id, $keys)];

                // and add the 'result' to employee
                $employee->addSimpleAdditiveWeightingValue('result', $employeeSimpleAdditiveWeightingResult->get($index));

                return $employee;
            });

        return $employees->sortByDesc('simple_additive_weighting.result')->values();
    }

    /**
     * @param Collection $criterias
     * @param Collection $employeeSubCriterias
     * @return mixed
     */
    public function moora(Collection $criterias, Collection $employeeSubCriterias)
    {
        $moora = new Moora();
        $moora->setPrecision(2);

        $employeeIds = null;

        $this->addDatas($moora, $criterias, $employeeSubCriterias, $employeeIds);
        $moora->calculate();

        // we're combining the employees ids as a key and the SAW result as a values
        $employeeMooraResult = collect(
            array_combine(
                $employeeIds->toArray(),
                $moora->getResult()
            )
        );

        $employees = Employee::whereIn('id', $employeeMooraResult->keys())
            ->get()
            ->map(function ($employee) use ($employeeMooraResult) {

                // we must be found the key of employee id
                $keys = $employeeMooraResult->keys()->toArray();
                $index = $keys[array_search($employee->id, $keys)];

                // and add the 'result' to employee
                $employee->addMooraValue('result', $employeeMooraResult->get($index));

                return $employee;
            });

        return $employees->sortByDesc('moora.result')->values();
    }
}
