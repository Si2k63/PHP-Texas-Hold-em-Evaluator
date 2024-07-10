<?php

namespace Si2k63\PokerHandEvaluator;

use Si2k63\PokerHandEvaluator\Interfaces\EvaluatorResult;
use Si2k63\PokerHandEvaluator\Interfaces\HandEvaluator;

abstract class AbstractEvaluator implements HandEvaluator
{
    protected array $rankedHands = [];

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

        if (!array_key_exists($value, $this->rankedHands)) {
            throw new \Exception("Invalid hand supplied to evaluator.");
        }

        return $this->rankedHands[$value];
    }

    /**
     * Take an instance of a hand and its rank and return its full English name.
     * @param Hand $hand
     * @param int $rank
     *
     * @return string
     */
    protected function getName(Hand $hand, int $rank): string
    {
        throw new \Exception("Cannot determine the name of hand '" . $hand->toString() . "' and rank '" . $rank . "' because '" . get_called_class() . "' has not implemented a getName method");
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
