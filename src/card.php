<?php

class card
{
    private $rank;
    private $rankName;
    private $rankValue;

    private $suit;
    private $suitName;
    private $suitValue;
    
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
        'c' => array('value' => 41, 'name' => 'Clubs'),
        'h' => array('value' => 43, 'name' => 'Hearts'),
        'd' => array('value' => 47, 'name' => 'Diamonds'),
        's' => array('value' => 53, 'name' => 'Spades')
    );

    public function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->rankValue = self::$ranks[$rank]["value"];
        $this->rankName = self::$ranks[$rank]["name"];

        $this->suit = $suit;
        $this->suitValue = self::$suits[$suit]["value"];
        $this->suitName = self::$suits[$suit]["name"];
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

    public function getSuitName()
    {
        return $this->suitName;
    }

    public function getSuitValue()
    {
        return $this->suitValue;
    }

    public function getRankName()
    {
        return $this->rankName;
    }

    public function getRankValue()
    {
        return $this->rankValue;
    }
}

?>