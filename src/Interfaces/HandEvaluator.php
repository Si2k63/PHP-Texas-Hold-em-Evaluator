<?php

namespace Si2k63\PokerHandEvaluator\Interfaces;

use Si2k63\PokerHandEvaluator\Hand;

interface HandEvaluator
{
    public function evaluate(Hand $hand): EvaluatorResult;
    public static function getInstance(): HandEvaluator;
}
