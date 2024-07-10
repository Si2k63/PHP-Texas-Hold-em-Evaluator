<?php

namespace Si2k63\PokerHandEvaluator\Iterators;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Hand;
use Si2k63\PokerHandEvaluator\Card;

class HighCardHandIterator implements \IteratorAggregate
{
    private bool $sameSuit;

    public function __construct(bool $sameSuit = false)
    {
        $this->sameSuit = $sameSuit;
    }

    public function getIterator(): \Traversable
    {
        $ranks = Rank::excluding([Rank::Five, Rank::Four, Rank::Three, Rank::Two]);

        foreach ($ranks as $primaryIndex => $primaryRank) {
            foreach (Rank::slice($primaryIndex + 1) as $secondaryIndex => $secondaryRank) {
                foreach (Rank::slice($secondaryIndex + 1) as $tertiaryIndex => $tertiaryRank) {
                    foreach (Rank::slice($tertiaryIndex + 1) as $quarternaryIndex => $quarternaryRank) {
                        foreach (Rank::slice($quarternaryIndex + 1) as $quinaryIndex => $quinaryRank) {
                            if ($primaryIndex + 4 == $quinaryIndex || $primaryIndex == 0 && $secondaryIndex == 9) {
                                continue;
                            }
                            $hand = Hand::fromArray([
                                new Card($primaryRank, $this->sameSuit ? Suit::Clubs : Suit::Diamonds),
                                new Card($secondaryRank, Suit::Clubs),
                                new Card($tertiaryRank, Suit::Clubs),
                                new Card($quarternaryRank, Suit::Clubs),
                                new Card($quinaryRank, Suit::Clubs)
                            ]);

                            yield $hand;
                        }
                    }
                }
            }
        }
    }
}
