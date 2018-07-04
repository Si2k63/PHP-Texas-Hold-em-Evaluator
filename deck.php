<?php

class deck
{
    private $cards = array();

    public function __construct()
    {
        $suits = card::getSuits();
        $ranks = card::getRanks();

        for ($i = 0; $i < count($suits); $i++)
        {
            for ($k = 0; $k < count($ranks); $k++)
            {
                $card = new card($ranks[$k], $suits[$i]);
                $this->cards[]=$card;
            }
        }
    }

    public function shuffle()
    {
        if (count($this->cards))
        {
            shuffle($this->cards);
        }
        else
        {
            return false;
        }
    }

    public function draw()
    {
        if (count($this->cards))
        {
            $card = $this->cards[0];
            array_splice($this->cards, 0, 1);
            return $card;
        }
    }

    public function contains($card)
    {
        return in_array($card, $this->cards);
    }
}

?>