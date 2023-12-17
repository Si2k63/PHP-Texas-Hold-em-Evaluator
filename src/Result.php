<?php

namespace Si2k63\PokerHandEvaluator;

use Si2k63\PokerHandEvaluator\Interfaces\EvaluatorResult;

class Result implements EvaluatorResult
{
    private int $ranking;
    private string $name;

    public function __construct(int $ranking, string $name)
    {
        $this->ranking = $ranking;
        $this->name = $name;
    }

    public function getRanking(): int
    {
        return $this->ranking;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
