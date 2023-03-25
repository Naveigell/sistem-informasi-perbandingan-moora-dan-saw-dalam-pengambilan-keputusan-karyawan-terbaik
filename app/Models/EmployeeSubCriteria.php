<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSubCriteria extends Model
{
    use HasFactory;

    protected $table = 'employee_sub_criteria';

    protected $fillable = ['employee_id', 'sub_criteria_id', 'criteria_id'];
}
