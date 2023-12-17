<?php

namespace Si2k63\PokerHandEvaluator\Interfaces;

interface EvaluatorResult
{
    /**
     * Returns the full English name of the evaluated hand (e.g. Four of a Kind, Aces with a King kicker).
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the absolute rank of the hand (e.g. Royal Flush returns 1).
     * @return int
     */
    public function getRanking(): int;
}
