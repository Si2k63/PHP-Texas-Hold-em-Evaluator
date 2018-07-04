<?php

class card
{
    private $rank;
    private $suit;

    private static $ranks = array(
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

    private static $suits = array(
        'c' => 41,
        'h' => 43,
        'd' => 47,
        's' => 53
    );

    public function __construct($rank, $suit)
    {
        if (self::isValidRank($rank) && self::isValidSuit($suit))
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
        return self::$ranks[$this->rank] * self::$suits[$this->suit];
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

    public static function getRanks()
    {
        return array_keys(self::$ranks);
    }

    public static function getSuits()
    {
        return array_keys(self::$suits);  
    }

    public static function isValidSuit($suit)
    {
        return array_key_exists($suit, self::$suits);
    }

    public static function isValidRank($rank)
    {
        return array_key_exists($rank, self::$ranks);
    }    
}

?>