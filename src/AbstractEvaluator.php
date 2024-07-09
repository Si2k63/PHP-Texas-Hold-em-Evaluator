<?php

namespace Si2k63\PokerHandEvaluator;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Interfaces\EvaluatorResult;
use Si2k63\PokerHandEvaluator\Interfaces\HandEvaluator;

abstract class AbstractEvaluator implements HandEvaluator
{
    private array $rankedHands = [];

    public function addIterator(\Traversable $hands)
    {
        foreach ($hands as $hand) {
            $this->rankedHands[$hand->getRankValues()] = count($this->rankedHands) + 1;
        }
    }

    /**
     * Get a hand's absolute rank (e.g. Royal Flush returns 1).
     *
     * @param Hand $hand The hand instance to be ranked.
     *
     * @return int
     */
    protected function getRanking(Hand $hand): int
    {
        $value = $hand->getRankValues();

        if (array_key_exists($value, $this->rankedHands)) {
            return $this->rankedHands[$value];
        }

        throw new \Exception("Invalid hand supplied to evaluator.");
    }

    /**
     * Evaluates a hand and returns a result describing its rank and name.
     *
     * @return EvaluatorResult
     */
    public function evaluate(Hand $hand): EvaluatorResult
    {
        $rank = $this->getRanking($hand);
        $name = $this->getName($hand, $rank);

        return new Result(
            $rank,
            $name
        );
    }
}
