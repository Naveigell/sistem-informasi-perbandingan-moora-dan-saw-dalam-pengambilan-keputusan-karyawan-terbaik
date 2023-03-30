<?php

namespace App\Http\Controllers\Admin\Calculation;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\EmployeeSubCriteria;
use App\Services\CalculationService;
use App\Services\NormalizationService;
use Illuminate\Http\Request;

class SimpleAdditiveWeightingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index()
    {
        $criterias = Criteria::all();

        $employeesMatrix = Employee::with('subCriterias.subCriteria.criteria')->get();

        $employeesSubCriterias = EmployeeSubCriteria::with('employee', 'criteria', 'subCriteria')->get()->groupBy('criteria_id');
        $employeesNormalizationSAWFirst = optional($employeesSubCriterias->first())->map(fn ($item) => $item->employee);

        $normalizationService = new NormalizationService();
        $calculationService = new CalculationService();

        $normalizationSAW = $normalizationService->simpleAdditiveWeighting($criterias, $employeesSubCriterias);

        $calculationSAW = $calculationService->simpleAdditiveWeighting($criterias, $employeesSubCriterias);

        return view('admin.pages.simple_additive_weightings.index', compact(
            'criterias',
            'employeesMatrix',
            'employeesNormalizationSAWFirst',
            'normalizationSAW',
            'calculationSAW'
        ));
    }
}
