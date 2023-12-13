<?php

namespace Si2k63\PokerHandEvaluator;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Interfaces\EvaluatorResult;
use Si2k63\PokerHandEvaluator\Interfaces\HandEvaluator;

class Evaluator implements HandEvaluator
{
    private array $ranks = [];
    private array $rankedHands = [];
    private static $instance;

    public function __construct()
    {
        $this->ranks = Rank::cases();
        $this->straightFlushes();
        $this->fourOfAKind();
        $this->fullHouses();
        $this->flushes();
        $this->straights();
        $this->threeOfAKinds();
        $this->twoPairs();
        $this->pairs();
        $this->highCards();
    }

    private function straightFlushes(): void
    {
        $this->straights(true);
    }

    private function addRankedHand(array $cards)
    {
        $hand = Hand::fromArray($cards);
        $this->rankedHands[$hand->getRankValues()] = count($this->rankedHands) + 1;
    }

    private function fourOfAKind(): void
    {
        foreach ($this->ranks as $primaryRank) {
            foreach ($this->ranks as $secondaryRank) {
                if ($primaryRank->value === $secondaryRank->value) {
                    continue;
                }
                $cards = [
                    new Card($primaryRank, Suit::Diamonds),
                    new Card($primaryRank, Suit::Hearts),
                    new Card($primaryRank, Suit::Clubs),
                    new Card($primaryRank, Suit::Spades),
                    new Card($secondaryRank, Suit::Hearts),
                ];

                $this->addRankedHand($cards);
            }
        }
    }

    private function fullHouses(): void
    {
        foreach ($this->ranks as $primaryRank) {
            foreach ($this->ranks as $secondaryRank) {
                if ($primaryRank === $secondaryRank) {
                    continue;
                }
                $this->addRankedHand([
                    new Card($primaryRank, Suit::Diamonds),
                    new Card($primaryRank, Suit::Hearts),
                    new Card($primaryRank, Suit::Clubs),
                    new Card($secondaryRank, Suit::Clubs),
                    new Card($secondaryRank, Suit::Hearts),
                ]);
            }
        }
    }

    private function flushes(): void
    {
        $this->highCards(true);
    }


    private function straights(bool $sameSuit = false): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->addRankedHand([
                new Card($this->ranks[$i], $sameSuit ? Suit::Diamonds : Suit::Clubs),
                new Card($this->ranks[$i + 1], Suit::Diamonds),
                new Card($this->ranks[$i + 2], Suit::Diamonds),
                new Card($this->ranks[$i + 3], Suit::Diamonds),
                new Card($this->ranks[$i + 4 > 12 ? 0 : $i + 4], Suit::Diamonds),
            ]);
        }
    }

    private function threeOfAKinds(): void
    {
        for ($a = 0; $a < count($this->ranks); $a++) {
            for ($b = 0; $b < count($this->ranks); $b++) {
                for ($c = $b + 1; $c < count($this->ranks); $c++) {
                    if ($a == $b || $a == $c) {
                        continue;
                    }
                    $this->addRankedHand([
                        new Card($this->ranks[$a], Suit::Diamonds),
                        new Card($this->ranks[$a], Suit::Clubs),
                        new Card($this->ranks[$a], Suit::Hearts),
                        new Card($this->ranks[$b], Suit::Spades),
                        new Card($this->ranks[$c], Suit::Diamonds),
                    ]);
                }
            }
        }
    }

    private function twoPairs(): void
    {
        for ($a = 0; $a < count($this->ranks); $a++) {
            for ($b = $a + 1; $b < count($this->ranks); $b++) {
                for ($c = 0; $c < count($this->ranks); $c++) {
                    if ($a == $b || $a == $c || $b == $c) {
                        continue;
                    }
                    $this->addRankedHand([
                        new Card($this->ranks[$a], Suit::Diamonds),
                        new Card($this->ranks[$a], Suit::Clubs),
                        new Card($this->ranks[$b], Suit::Hearts),
                        new Card($this->ranks[$b], Suit::Spades),
                        new Card($this->ranks[$c], Suit::Diamonds),
                    ]);
                }
            }
        }
    }

    private function highCards(bool $sameSuit = false): void
    {
        for ($a = 0; $a < count($this->ranks); $a++) {
            for ($b = $a + 1; $b < count($this->ranks); $b++) {
                for ($c = $b + 1; $c < count($this->ranks); $c++) {
                    for ($d = $c + 1; $d < count($this->ranks); $d++) {
                        for ($e = $d + 1; $e < count($this->ranks); $e++) {
                            if ($a + 4 == $e || $a == 0 && $b == 9 && $c == 10 && $d == 11 && $e == 12) {
                                continue;
                            }
                            $this->addRankedHand([
                                new Card($this->ranks[$a], $sameSuit ? Suit::Diamonds :  Suit::Clubs),
                                new Card($this->ranks[$b], Suit::Diamonds),
                                new Card($this->ranks[$c], Suit::Diamonds),
                                new Card($this->ranks[$d], Suit::Diamonds),
                                new Card($this->ranks[$e], Suit::Diamonds),
                            ]);
                        }
                    }
                }
            }
        }
    }

    private function pairs()
    {
        for ($a = 0; $a < count($this->ranks); $a++) {
            for ($b = 0; $b < count($this->ranks); $b++) {
                for ($c = $b + 1; $c < count($this->ranks); $c++) {
                    for ($d = $c + 1; $d < count($this->ranks); $d++) {
                        if ($a == $b || $a == $c || $a == $d || $b == $d) {
                            continue;
                        }

                        $this->addRankedHand([
                            new Card($this->ranks[$a], Suit::Diamonds),
                            new Card($this->ranks[$a], Suit::Hearts),
                            new Card($this->ranks[$b], Suit::Clubs),
                            new Card($this->ranks[$c], Suit::Spades),
                            new Card($this->ranks[$d], Suit::Diamonds),
                        ]);
                    }
                }
            }
        }
    }

    private function getRank(Hand $hand): int
    {
        $value = $hand->getRankValues();

        if (array_key_exists($value, $this->rankedHands)) {
            return $this->rankedHands[$value];
        }

        throw new \Exception("Invalid hand supplied to evaluator.");
    }

    private function getName(Hand $hand, int $rank): string
    {
        $cards = $hand->sortByRank()->getCards();

        // fix inconsistencies
        $firstCardName = $cards[0]->getRank()->name;
        $secondCard = $cards[1]->getRank()->name;
        $thirdCard = $cards[2]->getRank()->name;
        $fourthCard = $cards[3]->getRank()->name;
        $fifthCard = $cards[4]->getRank()->name;
        $article = $fifthCard == 'Ace' ? 'an' : 'a';
        $kicker = $article . ' ' . $fifthCard . ' kicker.';

        if ($rank === 1) {
            return "Royal Flush.";
        }

        if (in_array($rank, range(2, 9))) {
            return 'Straight Flush, ' . $firstCardName . ' high.';
        }

        if ($rank === 10) {
            return 'Straight Flush, ' . $secondCard . ' high.';
        }

        if (in_array($rank, range(11, 166))) {
            return 'Four of a Kind, ' . $firstCardName . 's with ' . $kicker;
        }

        if (in_array($rank, range(167, 322))) {
            return 'Full House, ' . $firstCardName . 's full of ' . $fifthCard . 's.';
        }

        if (in_array($rank, range(323, 1599))) {
            return 'Flush, ' . $firstCardName . ' high - ' . $firstCardName . ', ' . $secondCard . ', ' . $thirdCard . ', ' . $fourthCard . ', ' . $fifthCard . '.';
        }

        if (in_array($rank, range(1600, 1608))) {
            return 'Straight, ' . $firstCardName . ' high - ' . $firstCardName . ', ' . $secondCard . ', ' . $thirdCard . ', ' . $fourthCard . ', ' . $fifthCard . '.';
        }

        if ($rank === 1609) {
            return 'Straight, ' . $secondCard . ' high - ' . $secondCard . ', ' . $thirdCard . ', ' . $fourthCard . ', ' . $fifthCard . ', ' . $firstCardName . '.';
        }

        if (in_array($rank, range(1610, 2467))) {
            return 'Three of a Kind, ' . $firstCardName . 's with ' . $fourthCard . ' and ' .  $fifthCard . ' kickers.';
        }

        if (in_array($rank, range(2468, 3325))) {
            return 'Two pair, ' . $firstCardName . 's and ' . $thirdCard . 's with ' . $kicker;
        }

        if (in_array($rank, range(3326, 6185))) {
            return 'One Pair, ' . $firstCardName . 's with ' . $thirdCard . ', ' . $fourthCard . ', ' . $fifthCard . ' kickers.';
        }

        return $firstCardName . ' high - ' . $firstCardName . ', ' . $secondCard . ', ' . $thirdCard . ', ' . $fourthCard . ', ' . $fifthCard . '.';
    }

    public function evaluate(Hand $hand): EvaluatorResult
    {
        $rank = $this->getRank($hand);
        $name = $this->getName($hand, $rank);

        return new Result(
            $rank,
            $name
        );
    }

    public static function getInstance(): HandEvaluator
    {
        if (self::$instance === null) {
            self::$instance = new Evaluator();
        }

        return self::$instance;
    }
}
