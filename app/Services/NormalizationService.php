<?php

namespace App\Services;

use App\Libraries\Moora;
use App\Libraries\SimpleAdditiveWeighting;
use Illuminate\Support\Collection;

class NormalizationService extends DecisionSupportSystemBaseService
{
    /**
     * @param Collection $criterias
     * @param Collection $employeeSubCriterias
     * @return array
     */
    public function simpleAdditiveWeighting(Collection $criterias, Collection $employeeSubCriterias)
    {
        $simpleAdditiveWeighting = new SimpleAdditiveWeighting();
        $simpleAdditiveWeighting->setPrecision(2);

        $employeeIds = null;

        $this->addDatas($simpleAdditiveWeighting, $criterias, $employeeSubCriterias, $employeeIds);

        $simpleAdditiveWeighting->normalize();

        return $simpleAdditiveWeighting->getNormalizeData();
    }

    /**
     * @param Collection $criterias
     * @param Collection $employeeSubCriterias
     * @return array
     */
    public function moora(Collection $criterias, Collection $employeeSubCriterias)
    {
        $moora = new Moora();
        $moora->setPrecision(2);

        $employeeIds = null;

        $this->addDatas($moora, $criterias, $employeeSubCriterias, $employeeIds);

        return $moora->getNormalizeData();
    }
}
