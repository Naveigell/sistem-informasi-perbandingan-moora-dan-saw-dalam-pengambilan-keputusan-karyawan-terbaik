<?php

namespace App\Libraries;

abstract class DecisionSupportSystem
{
    protected $dataLength = null;

    public abstract function getResult();
    public abstract function setPrecision($precision);
    public abstract function rejectWeightIfMoreThanOne($rejectWeightIfMoreThanOne = true);
    public abstract function getData();
    public abstract function getNormalizeData();

    public function ensureIfAllDataContainsSameLength(array $data)
    {
        // if the data length is lower or equal than 1, we don't need to check if every array has same length
        if (count($data) <= 1) {
            $this->dataLength = count($data);

            return;
        }

        $length = null;

        foreach ($data as $datum) {

            // if length doesn't have value, we must initialize it by the first length of datum
            if (!$length) {
                $length = count($datum['data']);
            }

            if (count($datum['data']) != $length) {
                throw new \Error("The data length is not same, make sure it has same length");
            }
        }

        $this->dataLength = $length;
    }
}
