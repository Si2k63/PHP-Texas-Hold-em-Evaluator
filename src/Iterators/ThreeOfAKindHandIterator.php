<?php

namespace Si2k63\PokerHandEvaluator\Iterators;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Hand;
use Si2k63\PokerHandEvaluator\Card;

class ThreeOfAKindHandIterator implements \IteratorAggregate
{
    public function getIterator(): \Traversable
    {
        foreach (Rank::cases() as $primaryRank) {
            foreach (Rank::excluding([$primaryRank]) as $secondaryIndex => $secondaryRank) {
                foreach (Rank::slice($secondaryIndex + 1) as $tertiaryRank) {
                    if ($tertiaryRank == $primaryRank) {
                        continue;
                    }
                    yield Hand::fromArray([
                        new Card($primaryRank, Suit::Diamonds),
                        new Card($primaryRank, Suit::Clubs),
                        new Card($primaryRank, Suit::Hearts),
                        new Card($secondaryRank, Suit::Spades),
                        new Card($tertiaryRank, Suit::Diamonds),
                    ]);
                }
            }
        }
    }
}
