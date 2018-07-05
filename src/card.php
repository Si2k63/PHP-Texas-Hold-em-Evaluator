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

    private static $names = array(
        '2' => 'Two',
        '3' => 'Three',
        '4' => 'Four',
        '5' => 'Five',
        '6' => 'Six',
        '7' => 'Seven',
        '8' => 'Eight',
        '9' => 'Nine',
        'T' => 'Ten',
        'J' => 'Jack',
        'Q' => 'Queen',
        'K' => 'King',
        'A' => 'Ace',
    );

    private static $suits = array(
        'c' => 41,
        'h' => 43,
        'd' => 47,
        's' => 53
    );

    public function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }
    
    public function getRank()
    {
        return $this->rank;
    }

    public function getSuit()
    {
        return $this->suit;
    }


    public function toString()
    {
        return $this->rank . $this->suit;
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
    
    public static function getSuitValue($suit)
    {
        if (self::isValidSuit($suit))
        {
            return self::$suits[$suit];
        }
        else
        {
            return false;
        }
    }

    public static function getRankValue($rank)
    {
        if (self::isValidRank($rank))
        {
            //echo "$rank ";
            return self::$ranks[$rank];
        }
        else
        {
            return false;
        }
    }

    public function getRankName()
    {
        return self::$names[$this->rank];
    }
}

?>