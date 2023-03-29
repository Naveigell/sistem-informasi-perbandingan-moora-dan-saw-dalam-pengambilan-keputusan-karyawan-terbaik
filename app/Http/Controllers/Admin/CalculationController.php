<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\SimpleAdditiveWeighting;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\EmployeeSubCriteria;
use App\Services\CalculationService;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index()
    {
        $criterias = Criteria::all();
        $employeeSubCriterias = EmployeeSubCriteria::with('employee', 'criteria', 'subCriteria')->get()->groupBy('criteria_id');

        $calculationService = new CalculationService();

        $employeesSAW = $calculationService->simpleAdditiveWeighting($criterias, $employeeSubCriterias);
        $employeesMoora = $calculationService->moora($criterias, $employeeSubCriterias);

        return view('admin.pages.calculations.index', compact('employeesSAW', 'employeesMoora', 'criterias'));
    }
}
