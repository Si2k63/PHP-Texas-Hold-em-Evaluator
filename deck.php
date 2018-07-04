<?php

class deck
{
    var $suits = array('c','h','d','s');
    var $ranks = array('2','3','4','5','6','7','8','9','10','J','Q','K','A');
    var $cards = array();

    public function __construct()
    {
        for ($i = 0; $i < count($this->suits); $i++)
        {
            for ($k = 0; $k < count($this->ranks); $k++)
            {
                $card = new card($this->ranks[$k], $this->suits[$i]);
                $this->cards[]=$card;
            }
        }
    }

    public function shuffle()
    {
        shuffle($this->cards);
    }
}

?>