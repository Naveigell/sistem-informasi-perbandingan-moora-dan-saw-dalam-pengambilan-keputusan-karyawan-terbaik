<?php

namespace App\Http\Requests\Admin;

use App\Models\Criteria;
use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /**
         * @var Employee $employee
         */
        $employee = $this->route('employee');
        $criterias = Criteria::with('subCriterias')->get();

        $criteriaRules = [];
        $rules = [
            "name" => "required|string|max:150",
            "email" => "required|string|unique:employees|max:150",
            "phone" => "required|string|unique:employees|max:20",
            "address" => "required|string|max:350",
        ];

        foreach ($criterias as $criteria) {
            $criteriaRules["criteria_{$criteria->id}"] = "required|string|in:" . $criteria->subCriterias->pluck('id')->join(',');
        }

        if ($this->isMethod('put')) {
            if ($this->email == $employee->email) {
                $rules["email"] = "required|string|max:150";
            }

            if ($this->phone == $employee->phone) {
                $rules["phone"] = "required|string|max:20";
            }
        }

        return array_merge($rules, $criteriaRules);
    }

    public function getCriteriaIds()
    {
        $ids = Criteria::pluck('id')->map(fn ($id) => "criteria_{$id}")->toArray();

        return collect(
            $this->only($ids)
        );
    }
}
