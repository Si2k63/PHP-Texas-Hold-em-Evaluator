<?php

namespace Si2k63\PokerHandEvaluator;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;

class Hand
{
    private $cards = [];

    /**
     * Add a card instance to the hand.
     * @param Card $card
     * 
     * @return void
     */
    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * Return an array of the cards contained in the hand
     * @return Card[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Sort the cards in the hand by their rank.
     * @return Hand
     */
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

    /**
     * Convert the hand to a human readable string (e.g. Ad Kd Qd Jd Td).
     * @return string
     */
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

    /**
     * Generate a unique identifier for the hand that can be used against the lookup table in an Evaluator to determine its absolute rank.
     * @return int
     */
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

    /**
     * Create a hand instance from an array of cards.
     * @param array $cards
     * 
     * @return Hand
     */
    public static function fromArray(array $cards): Hand
    {
        $hand = new Hand();
        foreach ($cards as $card) {
            $hand->addCard($card);
        }
        return $hand;
    }

    /**
     * Create a hand instance from a string in the following format: Ad Ac Kd Ks 4h
     * @param string $hand
     *
     * @return Hand
     */
    public static function fromString(string $hand): Hand
    {
      $cards = explode(" ", $hand);

      if (count($cards) < 5) {
        throw new \Exception("Invalid hand string supplied");
      }

      $hand = new Hand();

      foreach ($cards as $card) {
        $rank = Rank::fromString($card[0]);
        $suit = Suit::fromString($card[1]);
        $card = new Card($rank, $suit);
        $hand->addCard($card);
      }

      return $hand;
    }
}
