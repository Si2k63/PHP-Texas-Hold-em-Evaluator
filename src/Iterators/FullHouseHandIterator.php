<?php

namespace Si2k63\PokerHandEvaluator\Iterators;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Hand;
use Si2k63\PokerHandEvaluator\Card;

class FullHouseHandIterator implements \IteratorAggregate
{
    public function getIterator(): \Traversable
    {
        foreach (Rank::cases() as $primaryRank) {
            foreach (Rank::excluding([$primaryRank]) as $secondaryRank) {
                yield Hand::fromArray([
                    new Card($primaryRank, Suit::Diamonds),
                    new Card($primaryRank, Suit::Hearts),
                    new Card($primaryRank, Suit::Clubs),
                    new Card($secondaryRank, Suit::Clubs),
                    new Card($secondaryRank, Suit::Hearts),
                ]);
            }
        }
    }
}
