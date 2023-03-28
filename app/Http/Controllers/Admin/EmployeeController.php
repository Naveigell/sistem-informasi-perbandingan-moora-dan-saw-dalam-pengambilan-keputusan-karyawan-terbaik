<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\SubCriteria;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $employees = Employee::with('subCriterias.criteria', 'subCriterias.subCriteria')->latest()->paginate(10);

        return view('admin.pages.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $criterias = Criteria::with('subCriterias')->get();

        return view('admin.pages.employees.form', compact('criterias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeRequest $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EmployeeRequest $request)
    {
        DB::transaction(function () use ($request) {
            $employee = Employee::create($request->validated());

            $employeeSubCriterias = $this->getEmployeeSubCriterias($request);

            $employee->subCriterias()->createMany($employeeSubCriterias);
        });

        return redirect(route('admin.employees.index'))->with('success', 'Data pegawai berhasil ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Employee $employee
     * @return Application|Factory|View
     */
    public function edit(Employee $employee)
    {
        $employee->load('subCriterias.criteria', 'subCriterias.subCriteria');

        $criterias = Criteria::with('subCriterias')->get();

        return view('admin.pages.employees.form', compact('employee', 'criterias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeRequest $request
     * @param Employee $employee
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        DB::transaction(function () use ($request, $employee) {
            $employee->update($request->validated());

            $employeeSubCriterias = $this->getEmployeeSubCriterias($request);

            $employee->subCriterias()->delete();
            $employee->subCriterias()->createMany($employeeSubCriterias);
        });

        return redirect(route('admin.employees.index'))->with('success', 'Data pegawai berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect(route('admin.employees.index'))->with('success', 'Data pegawai berhasil dihapus');
    }

    private function getEmployeeSubCriterias(EmployeeRequest $request)
    {
        $subCriterias = SubCriteria::whereIn('id', $request->getCriteriaIds()->values())->get();

        $employeeSubCriterias = [];

        foreach ($subCriterias->pluck('criteria_id', 'id') as $id => $criteriaId) {
            $employeeSubCriterias[] = [
                "criteria_id" => $criteriaId,
                "sub_criteria_id" => $id,
            ];
        }

        return $employeeSubCriterias;
    }
}
