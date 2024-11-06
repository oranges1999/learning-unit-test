<?php

namespace App\Service;

class InteractWithTwoNumber
{
    public function sum($x, $y)
    {
        return round($x+$y,4);
    }

    public function subtract($x, $y)
    {
        return round($x-$y,4);
    }
}