<?php

namespace Si2k63\PokerHandEvaluator;

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;

class Deck
{
    private $cards = [];

    public function __construct()
    {
        $suits = Suit::cases();
        $ranks = Rank::cases();

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $this->cards[] = new Card($rank, $suit);
            }
        }
    }

    public function shuffle(): void
    {
        $totalCards = count($this->cards);
        if ($totalCards < 2) {
            throw new \Exception('You cannot shuffle a deck with only ' . $totalCards . ' in it.');
        }

        shuffle($this->cards);
    }

    public function contains(Card $card)
    {
        foreach ($this->cards as $deckCard) {
            if ($deckCard->matches($card->getRank(), $card->getSuit())) {
                return true;
            }
        }

        return false;
    }

    public function drawCards(int $count = 1): array
    {
        $cards = [];

        if ($count > count($this->cards)) {
            throw new \Exception('There aren\'t that many cards remaining in the deck!');
        }

        if ($count < 1) {
            throw new \Exception('Invalid count of cards to draw passed.');
        }

        for ($i = 0; $i < $count; $i++) {
            $cards = [...$cards, ...array_splice($this->cards, 0, 1)];
        }

        return $cards;
    }

    public function getCard(Rank $rank, Suit $suit): Card
    {
        foreach ($this->cards as $key => $card) {
            if ($card->matches($rank, $suit)) {
                array_splice($this->cards, $key, 1);
                return $card;
            }
        }

        throw new \Exception('Supplied card is not present in the deck!');
    }
}
