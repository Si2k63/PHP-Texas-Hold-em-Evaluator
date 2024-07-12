<?php

namespace Si2k63\PokerHandEvaluator\Iterators;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Hand;
use Si2k63\PokerHandEvaluator\Card;

class PairHandIterator implements \IteratorAggregate
{
    public function getIterator(): \Traversable
    {
        $ranks = Rank::cases();

        foreach ($ranks as $primaryRank) {
            foreach (Rank::excluding([$primaryRank]) as $secondaryIndex => $secondaryRank) {
                foreach (Rank::slice($secondaryIndex + 1) as $tertiaryIndex => $tertiaryRank) {
                    foreach (Rank::slice($tertiaryIndex + 1) as $quarternaryRank) {
                        if (in_array($primaryRank, [$tertiaryRank, $quarternaryRank])) {
                            continue;
                        }
                        yield Hand::fromArray([
                            new Card($primaryRank, Suit::Diamonds),
                            new Card($primaryRank, Suit::Hearts),
                            new Card($secondaryRank, Suit::Clubs),
                            new Card($tertiaryRank, Suit::Spades),
                            new Card($quarternaryRank, Suit::Diamonds),
                        ]);
                    }
                }
            }
        }
    }
}
