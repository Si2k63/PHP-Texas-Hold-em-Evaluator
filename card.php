<?php

class card
{
    private $rank;
    private $suit;

    private static $rankPrimes = array(
        '2' => 2,
        '3' => 3,
        '4' => 5,
        '5' => 7,
        '6' => 9,
        '7' => 11,
        '8' => 13,
        '9' => 17,
        'T' => 19,
        'J' => 23,
        'Q' => 29,
        'K' => 31,
        'A' => 37,
    );

    private static $suitPrimes = array(
        'c' => 41,
        'h' => 43,
        'd' => 47,
        's' => 53
    );

    public function __construct($rank, $suit)
    {
        if (deck::isValidRank($rank) && deck::isValidSuit($suit))
        {
            $this->rank = $rank;
            $this->suit = $suit;
        }
        else
        {
            return false;
        }
    }

    public function getId()
    {
        return $rankPrimes[$this->rank] * $suitPrimes[$suit];
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function getSuit()
    {
        return $this->suit;
    }


    public function display()
    {
        echo $this->rank . $this->suit . PHP_EOL;
    }
}

?>