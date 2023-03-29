<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address'];

    protected $appends = ['simple_additive_weighting', 'moora'];

    // this is custom property for every decision support system
    private $calculation = [];

    public function addMooraValue($key, $value)
    {
        $this->calculation['moora'][$key] = $value;
    }

    public function addSimpleAdditiveWeightingValue($key, $value)
    {
        $this->calculation['simple_additive_weighting'][$key] = $value;
    }

    public function getMooraAttribute()
    {
        if (array_key_exists('moora', $this->calculation)) {
            return $this->calculation['moora'];
        }
    }

    public function getSimpleAdditiveWeightingAttribute()
    {
        if (array_key_exists('simple_additive_weighting', $this->calculation)) {
            return $this->calculation['simple_additive_weighting'];
        }
    }

    public function subCriterias()
    {
        return $this->hasMany(EmployeeSubCriteria::class);
    }
}
