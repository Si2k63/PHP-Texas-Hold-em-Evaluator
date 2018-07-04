<?php

class card
{
    private $rank;
    private $suit;

    function __construct($rank, $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    function getRank()
    {
        return $this->rank;
    }

    function getSuit()
    {
        return $this->suit;
    }
}


?>