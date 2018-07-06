<?php

class card
{
    private $rank;
    private $suit;

    private static $ranks = array(
        '2' => array('value' => 2, 'name' => 'Two'),
        '3' => array('value' => 3, 'name' => 'Three'),
        '4' => array('value' => 5, 'name' => 'Four'),
        '5' => array('value' => 7, 'name' => 'Five'),
        '6' => array('value' => 9, 'name' => 'Six'),
        '7' => array('value' => 11, 'name' => 'Seven'),
        '8' => array('value' => 13, 'name' => 'Eight'),
        '9' => array('value' => 17, 'name' => 'Nine'),
        'T' => array('value' => 19, 'name' => 'Ten'),
        'J' => array('value' => 23, 'name' => 'Jack'),
        'Q' => array('value' => 29, 'name' => 'Queen'),
        'K' => array('value' => 31, 'name' => 'King'),
        'A' => array('value' => 37, 'name' => 'Ace')
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
            return self::$ranks[$rank]["value"];
        }
        else
        {
            return false;
        }
    }

    public function getRankName()
    {
        return self::$ranks[$this->rank]["name"];
    }
}

?>