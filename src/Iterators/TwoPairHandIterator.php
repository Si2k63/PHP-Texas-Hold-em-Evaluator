<?php

namespace Si2k63\PokerHandEvaluator\Iterators;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Hand;
use Si2k63\PokerHandEvaluator\Card;

class TwoPairHandIterator implements \IteratorAggregate
{
    public function getIterator(): \Traversable
    {
        foreach (Rank::cases() as $primaryRank) {
            foreach (Rank::excluding([$primaryRank]) as $secondaryRank) {
                foreach (Rank::excluding([$primaryRank, $secondaryRank]) as $tertiaryRank) {
                    yield Hand::fromArray([
                        new Card($primaryRank, Suit::Diamonds),
                        new Card($primaryRank, Suit::Clubs),
                        new Card($secondaryRank, Suit::Hearts),
                        new Card($secondaryRank, Suit::Spades),
                        new Card($tertiaryRank, Suit::Diamonds),
                    ]);
                }
            }
        }
    }
}