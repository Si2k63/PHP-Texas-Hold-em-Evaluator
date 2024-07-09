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
        for ($a = 0; $a < count($ranks); $a++) {
            for ($b = 0; $b < count($ranks); $b++) {
                for ($c = $b + 1; $c < count($ranks); $c++) {
                    for ($d = $c + 1; $d < count($ranks); $d++) {
                        if ($a == $b || $a == $c || $a == $d || $b == $d) {
                            continue;
                        }

                        yield Hand::fromArray([
                            new Card($ranks[$a], Suit::Diamonds),
                            new Card($ranks[$a], Suit::Hearts),
                            new Card($ranks[$b], Suit::Clubs),
                            new Card($ranks[$c], Suit::Spades),
                            new Card($ranks[$d], Suit::Diamonds),
                        ]);
                    }
                }
            }
        }
    }
}
