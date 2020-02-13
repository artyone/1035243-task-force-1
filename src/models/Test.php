<?php


namespace app\models;


class Test
{

    public function sort($array)
    {
        foreach ($array as $value) {
            $exit = true;
            for ($i = 1; $i < count($array); $i++) {
                $value1 = $array[$i - 1];
                $value2 = $array[$i];
                if ($value1 > $value2) {
                    $array[$i - 1] = $value2;
                    $array[$i] = $value1;
                    $exit = false;
                }
            }
            if ($exit) {
                break;
            }
        }
        print_r($array);
    }

    public function quickSort(&$array)
    {
        $left = 0;
        $right = count($array) - 1;

        $this->sort2($array, $left, $right);
        print_r($array);
    }

    private function sort2(&$array, $left, $right)
    {
        $l = $left;
        $r = $right;
        $center = $array[(int)($left + $right) / 2];
        do {
            while ($array[$r] > $center) {
                $r--;
            }
            while ($array[$l] < $center) {
                $l++;
            }
            if ($l <= $r) {
                list($array[$r], $array[$l]) = array($array[$l], $array[$r]);
                $l++;
                $r--;
            }
        } while ($l <= $r);
        if ($r > $left) {
            $this->sort2($array, $left, $r);
        }
        if ($l < $right) {
            $this->sort2($array, $l, $right);
        }
    }
}


