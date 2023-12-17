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
    /**
     * Returns the Rank associated with the current instance of the card.
     * @return Rank
     */
    public function getRank(): Rank
    {
        return $this->rank;
    }

    /**
     * Returns the Suit associated with the current instance of the card.
     * @return Suit
     */
    public function getSuit(): Suit
    {
        return $this->suit;
    }

    /**
     * Convert the Card instance to a human readable string (e.g. Ad).
     * @return string
     */
    public function toString(): string
    {
        return $this->rank->getShortName() . $this->suit->getShortName();
    }

    /**
     * Get the unique integer for this card.
     * @return int
     */
    public function getValue(): int
    {
        return $this->rank->value * $this->suit->value;
    }

    /**
     * Check whether the current Card instance matches a specific rank and suit.
     * @param Rank $rank
     * @param Suit $suit
     * 
     * @return bool
     */
    public function matches(Rank $rank, Suit $suit): bool
    {
        if ($this->rank->value !== $rank->value) {
            return false;
        }

        if ($this->suit->value !== $suit->value) {
            return false;
        }

        return true;
    }
}
