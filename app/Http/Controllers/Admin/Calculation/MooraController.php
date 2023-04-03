<?php

namespace App\Http\Controllers\Admin\Calculation;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\EmployeeSubCriteria;
use App\Services\CalculationService;
use App\Services\NormalizationService;
use Illuminate\Http\Request;

class MooraController extends Controller
{
    public function index()
    {
        $criterias = Criteria::all();

        $employeesMatrix = Employee::with('subCriterias.subCriteria.criteria')->get();

        $employeesSubCriterias = EmployeeSubCriteria::with('employee', 'criteria', 'subCriteria')->get()->groupBy('criteria_id');
        $employeesNormalizationMooraFirst = optional($employeesSubCriterias->first())->map(fn ($item) => $item->employee);

        $normalizationService = new NormalizationService();
        $calculationService = new CalculationService();

        $normalizationMoora = $normalizationService->moora($criterias, $employeesSubCriterias);

        $calculationMoora = $calculationService->moora($criterias, $employeesSubCriterias);

        $employeesNormalizationMooraFirst = $employeesNormalizationMooraFirst->sortBy('id');

        return view('admin.pages.mooras.index', compact(
            'criterias',
            'employeesMatrix',
            'employeesNormalizationMooraFirst',
            'normalizationMoora',
            'calculationMoora'
        ));
    }
}
