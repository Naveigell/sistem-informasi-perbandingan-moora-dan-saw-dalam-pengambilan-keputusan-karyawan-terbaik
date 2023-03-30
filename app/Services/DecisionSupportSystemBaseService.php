<?php

namespace App\Services;

use App\Libraries\DecisionSupportSystem;
use Illuminate\Support\Collection;

class DecisionSupportSystemBaseService
{
    protected function addDatas(DecisionSupportSystem $system, Collection $criterias, Collection $employeeSubCriterias, &$employeeIds)
    {
        foreach ($employeeSubCriterias as $criteriaId => $employeeSubCriteria) {
            // we need to get the employee ids
            if (!$employeeIds) {
                $employeeIds = $employeeSubCriteria->pluck('employee_id');
            }

            $criteria = $criterias->where('id', $criteriaId)->first();

            $system->addData(
                $employeeSubCriteria->map(fn($item) => $item->subCriteria->value)->toArray(), // get every value from subcriteria
                $criteria->weight, // we must format weigth to not more than 1
                strtoupper($criteria->attribute),
            );
        }
    }
}
