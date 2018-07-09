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

    public function draw($count=1)
    {
        if (count($this->cards) >= $count && $count > 0)
        {
            if ($count == 1)
            {
                $card = $this->cards[0];
                array_splice($this->cards, 0, 1);
                return $card;
            }
            else
            {
                $cards = array();

                for ($i = 0; $i < $count; $i++)
                {
                    $card = $this->cards[0];
                    array_splice($this->cards, 0, 1);
                    $cards[]=$card;
                }

                return $cards;
            }
        }
        else
        {
            return false;
        }
    }

    public function card($rank, $suit)
    {
        $card = false;

        for ($i = 0; $i < count($this->cards); $i++)
        {
            if ($this->cards[$i]->getRank() == $rank && $this->cards[$i]->getSuit() == $suit)
            {
                $card = $this->cards[$i];
                array_splice($this->cards, $i, 1);
                break;
            }
        }

        return $card;
    }

    public function contains($card)
    {
        return in_array($card, $this->cards);
    }
}

?>