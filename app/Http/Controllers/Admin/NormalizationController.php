<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\EmployeeSubCriteria;
use App\Services\NormalizationService;
use Illuminate\Http\Request;

class NormalizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $criterias = Criteria::all();
        $employeeSubCriterias = EmployeeSubCriteria::with('employee', 'criteria', 'subCriteria')->get()->groupBy('criteria_id');

        $employees = optional($employeeSubCriterias->first())->map(fn ($item) => $item->employee);

        $normalizationService = new NormalizationService();

        $normalizationSAW = $normalizationService->simpleAdditiveWeighting($criterias, $employeeSubCriterias);
        $normalizationMoora = $normalizationService->moora($criterias, $employeeSubCriterias);

        return view('admin.pages.normalizations.index', compact('criterias', 'normalizationSAW', 'normalizationMoora', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
