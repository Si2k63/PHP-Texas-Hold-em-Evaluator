<?php

namespace Si2k63\PokerHandEvaluator;

use Si2k63\PokerHandEvaluator\Interfaces\EvaluatorResult;

class Result implements EvaluatorResult
{
    private int $rank;
    private string $name;

    public function __construct(int $rank, string $name)
    {
        $this->rank = $rank;
        $this->name = $name;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
