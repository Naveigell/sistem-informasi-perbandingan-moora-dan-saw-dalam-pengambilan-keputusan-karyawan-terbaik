<?php

namespace App\Libraries;

class SimpleAdditiveWeighting extends DecisionSupportSystem {

    private $data = [];
    private $normalize = [];
    private $result = [];

    private $rowsQuantifierOrDivisor = [];

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

            // check if criteria not in COST or BENEFIT
            if ($criteria == self::CRITERIA_COST) {
                $this->rowsQuantifierOrDivisor[] = min($data);
            } elseif ($criteria == self::CRITERIA_BENEFIT) {
                $this->rowsQuantifierOrDivisor[] = max($data);
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

    public function normalize()
    {
        $data = $this->data;

        $normalize = [];

        // loop every rows
        foreach ($data as $index => $datum) {
            // then loope every item and difide by its criteria
            foreach ($datum['data'] as $item) {
                if ($datum['criteria'] == self::CRITERIA_BENEFIT) {
                    $normalize[$index][] = round($item / $this->rowsQuantifierOrDivisor[$index], $this->precision);
                } else {
                    $normalize[$index][] = round($this->rowsQuantifierOrDivisor[$index] / $item, $this->precision);
                }
            }
        }

        $this->normalize = $normalize;
    }

    /**
     * Calculate the result
     *
     * @return void
     */
    public function calculate()
    {
        $preResult = [];

        // we need to calculate multiply every normalize with its height
        foreach ($this->normalize as $index => $rows) {
            foreach ($rows as $row) {
                $preResult[$index][] = round($this->data[$index]['weight'] * $row, $this->precision);
            }
        }

        $result = [];

        // and sum every column
        foreach (range(0, $this->dataLength - 1) as $range) {

            $sum = [];

            foreach ($preResult as $rows) {
                $sum[] = $rows[$range];
            }

            $result[] = round(array_sum($sum), $this->precision);
        }

        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setPrecision($precision)
    {
        $this->precision = $precision;
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

    public function getNormalizeData()
    {
        return $this->normalize;
    }
}
