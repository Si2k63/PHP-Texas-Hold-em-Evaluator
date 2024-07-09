<?php

namespace Si2k63\PokerHandEvaluator\Iterators;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Hand;
use Si2k63\PokerHandEvaluator\Card;

class StraightHandIterator implements \IteratorAggregate
{
    private bool $sameSuit;

    public function __construct(bool $sameSuit = false)
    {
        $this->sameSuit = $sameSuit;
    }

    public function getIterator(): \Traversable
    {
        $ranks = Rank::cases();

        for ($i = 0; $i < 10; $i++) {
            yield Hand::fromArray([
                new Card($ranks[$i], $this->sameSuit ? Suit::Diamonds : Suit::Clubs),
                new Card($ranks[$i + 1], Suit::Diamonds),
                new Card($ranks[$i + 2], Suit::Diamonds),
                new Card($ranks[$i + 3], Suit::Diamonds),
                new Card($ranks[$i + 4 > 12 ? 0 : $i + 4], Suit::Diamonds),
            ]);
        }
    }
}
