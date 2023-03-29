<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'weight', 'attribute'];

    const ATTRIBUTE_COST = 'cost';
    const ATTRIBUTE_BENEFIT = 'benefit';

    public function subCriterias()
    {
        return $this->hasMany(SubCriteria::class);
    }

    public function getWeightFormattedAttribute()
    {
        return $this->weight / 100;
    }
}
