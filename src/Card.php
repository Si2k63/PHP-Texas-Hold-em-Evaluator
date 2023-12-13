<?php

namespace Si2k63\PokerHandEvaluator;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;

class Card
{
    private Rank $rank;
    private Suit $suit;

    public function __construct(Rank $rank, Suit $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    public function getRank(): Rank
    {
        return $this->rank;
    }

    public function getSuit(): Suit
    {
        return $this->suit;
    }

    public function toString(): string
    {
        return $this->rank->getShortName() . $this->suit->getShortName();
    }

    public function getValue(): int
    {
        return $this->rank->value * $this->suit->value;
    }

    public function matches(Rank $rank, Suit $suit): bool
    {
        if ($this->rank !== $rank) {
            return false;
        }

        if ($this->suit !== $suit) {
            return false;
        }

        return true;
    }
}
