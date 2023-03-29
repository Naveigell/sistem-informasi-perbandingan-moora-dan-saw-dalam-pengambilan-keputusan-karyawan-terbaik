<?php

namespace App\Libraries;

class Moora extends DecisionSupportSystem
{
    private $data = [];
    private $normalize = [];
    private $result = [];

    private $precision = 3;

    /**
     * A variable option to reject if the weight is more than 1
     *
     * @var bool
     */
    private $rejectWeightIfMoreThanOne = false;

    const CRITERIA_COST = 'COST';
    const CRITERIA_BENEFIT = 'BENEFIT';

    /**
     * add data, but vertically, the data visualtization will be like this
     *
     * [
     *      -----    ----    ----   ----    ----
     *      | 4 |   | 5 |   | 3 |   | 1 |   | 1 |
     *      | 4 |   | 1 |   | 9 |   | 5 |   | 7 |
     *      | 4 |   | 1 |   | 7 |   | 9 |   | 8 |
     *      | 4 |   | 1 |   | 7 |   | 9 |   | 5 |
     *      | 4 |   | 1 |   | 7 |   | 9 |   | 8 |
     *      ----    ----    ----    ----    ----
     * ]
     *
     * @throws \Exception
     */
    public function addData($data, $weight = 1, $criteria = self::CRITERIA_COST)
    {
        if ($this->rejectWeightIfMoreThanOne && $weight > 1) {
            throw new \Exception("The weight is more than 1, adding data rejected");
        }  else {

            // check if criteria not COST or BENEFIT,
            // we don't need to create a function to normalize anymore because we can normalize here
            if (in_array($criteria, [self::CRITERIA_COST, self::CRITERIA_BENEFIT])) {
                // find the divider by pow every item and sum them
                $divider = array_map(function ($item) {
                    return pow($item, 2);
                }, $data);

                $divider = array_sum($divider);
                // then we need to find the square root
                $divider = sqrt($divider);
                $divider = round($divider, $this->precision);

                // now we normalize the data (divide every item by divider)
                $normalize = array_map(function ($item) use ($divider) {
                    return round($item / $divider, $this->precision);
                }, $data);

                $this->normalize[] = $normalize;

            } else {
                throw new \Exception("The criteria must be cost or benefit");
            }

            $this->data[] = [
                "data" => $data,
                "criteria" => $criteria,
                "weight" => $weight,
            ];
        }

        $this->ensureIfAllDataContainsSameLength($this->data);
    }

    public function calculate()
    {
        $preResult = [];

        // we need to calculate multiply every normalize with its weight
        foreach ($this->normalize as $index => $rows) {
            foreach ($rows as $row) {
                $preResult[$index][] = round($this->data[$index]['weight'] * $row, $this->precision);
            }
        }

        $result = [];

        // loop every row index
        foreach (range(0, $this->dataLength - 1) as $range) {
            $maximum = $minimum = 0;

            // loop every preresult and check if the 'criteria' is benefit
            // then add to maximum, else add to minimum
            foreach ($preResult as $index => $rows) {
                if ($this->data[$index]['criteria'] == self::CRITERIA_BENEFIT) {
                    $maximum += round($rows[$range], $this->precision);
                } else {
                    $minimum += round($rows[$range], $this->precision);
                }
            }

            // and then we must reduce maximum and minimum
            $result[] = round($maximum - $minimum, $this->precision);
        }

        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * Set reject the data if weight is more than 1
     *
     * @param bool $rejectWeightIfMoreThanOne
     */
    public function rejectWeightIfMoreThanOne($rejectWeightIfMoreThanOne = true)
    {
        $this->rejectWeightIfMoreThanOne = $rejectWeightIfMoreThanOne;
    }

    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }

    public function getNormalizeData()
    {
        return $this->normalize;
    }
}
