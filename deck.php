<?php

class deck
{
    private static $suits = array('c','h','d','s');
    private static $ranks = array('2','3','4','5','6','7','8','9','T','J','Q','K','A');
    private $cards = array();

    public function __construct()
    {
        for ($i = 0; $i < count(self::$suits); $i++)
        {
            for ($k = 0; $k < count(self::$ranks); $k++)
            {
                $card = new card(self::$ranks[$k], self::$suits[$i]);
                $card->display();
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

    public static function isValidSuit($suit)
    {
        return in_array($suit, self::$suits);
    }

    public static function isValidRank($rank)
    {
        return in_array($rank, self::$ranks);
    }

}

?>