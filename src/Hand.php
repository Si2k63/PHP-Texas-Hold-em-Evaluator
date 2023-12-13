<?php

namespace Si2k63\PokerHandEvaluator;

class Hand
{
    private $cards = [];

    public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function sortByRank(): Hand
    {
        usort($this->cards, function ($a, $b) {
            $aFreq = count(array_filter($this->cards, function ($card) use ($a) {
                return $card->getRank() == $a->getRank();
            })); // count how many cards of that rank exist in the array

            $bFreq = count(array_filter($this->cards, function ($card) use ($b) {
                return $card->getRank() == $b->getRank();
            }));

            if ($bFreq <> $aFreq) {
                return $bFreq > $aFreq ? 1 : -1;
            }

            return $a->getRank()->value < $b->getRank()->value;
        });

        return $this;
    }

    public function toString(): string
    {
        $mapped = array_map(
            function (Card $card) {
                return $card->toString();
            },
            $this->cards
        );
        return implode(' ', $mapped);
    }

    public function getRankValues(): int
    {
        $value = array_product(array_map(
            function (Card $card) {
                return $card->getRank()->value;
            },
            $this->cards
        ));

        $suits = array_map(
            function (Card $card) {
                return $card->getSuit()->value;
            },
            $this->cards
        );

        if (count(array_unique($suits)) == 1) {
            $value *= 49;
        }

        return $value;
    }

    public static function fromArray(array $cards)
    {
        $hand = new Hand();
        foreach ($cards as $card) {
            $hand->addCard($card);
        }
        return $hand;
    }
}
