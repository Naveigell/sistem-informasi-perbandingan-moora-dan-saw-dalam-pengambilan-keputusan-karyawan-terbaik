<?php

namespace App\Libraries;

class SimpleAdditiveWeighting {

    private $data = [];
    private $normalize = [];
    private $result = [];

    private $rowsQuantifierOrDivisor = [];

    /**
     * A variable option to reject if the weight is more than 1
     *
     * @var bool
     */
    private $rejectWeightIfMoreThanOne = false;

    const CRITERIA_COST = 'COST';
    const CRITERIA_BENEFIT = 'BENEFIT';

    const SORT_ASC = 'ASCENDING';
    const SORT_DESC = 'DESCENDING';

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
                    $normalize[$index][] = round($item / $this->rowsQuantifierOrDivisor[$index], 3);
                } else {
                    $normalize[$index][] = round($this->rowsQuantifierOrDivisor[$index] / $item, 3);
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
                $preResult[$index][] = $this->data[$index]['weight'] * $row;
            }
        }

        $result = [];

        // and sum every column
        foreach (range(0, count($preResult) - 1) as $range) {

            $sum = [];

            foreach ($preResult as $rows) {
                $sum[] = $rows[$range];
            }

            $result[] = array_sum($sum);
        }

        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
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
}
