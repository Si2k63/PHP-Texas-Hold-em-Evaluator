<?php

namespace Si2k63\PokerHandEvaluator\Interfaces;

interface EvaluatorResult
{
    public function getName(): string;
    public function getRank(): int;
}
