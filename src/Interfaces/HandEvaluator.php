<?php

namespace Si2k63\PokerHandEvaluator\Interfaces;

use Si2k63\PokerHandEvaluator\Hand;

interface HandEvaluator
{
    /**
     * Evaluate a hand and return a result containing its absolute rank and full English name.
     * @param Hand $hand
     * 
     * @return EvaluatorResult
     */
    public function evaluate(Hand $hand): EvaluatorResult;

    /**
     * Singleton to prevent duplicated work when initiating the evaluator.
     * @return HandEvaluator
     */
    public static function getInstance(): HandEvaluator;
}
