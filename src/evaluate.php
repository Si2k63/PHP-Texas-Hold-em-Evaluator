<?php

class evaluate
{
    var $rankings = array();
    var $done = 1;
    var $cards = array();

    var $highest;
    var $besthand;

    function __construct()
    {
        $this->cards = array(
            new card('2','d'),
            new card('3','d'),
            new card('4','d'),
            new card('5','d'),
            new card('6','d'),
            new card('7','d'),
            new card('8','d'),
            new card('9','d'),
            new card('T','d'),
            new card('J','d'),
            new card('Q','d'),
            new card('K','d'),
            new card('A','d')      
        );

        $this->straights(true);
        $this->quads();
        $this->fullhouses();
        $this->flushes(true);
        $this->straights();
        $this->trips();
        $this->twopairs();
        $this->pairs();
        $this->flushes();
    }

    function pairs()
    {
        for ($a = 12; $a >= 0; $a--)
        {
            for ($b = 12; $b >= 0; $b--)
            {
                for ($c = $b - 1; $c >= 0; $c--)
                {
                    for ($d = $c - 1; $d >= 0; $d--)
                    {
                        if ($a != $b && $a != $c && $a != $d && $b != $c && $b != $d && $c != $d)
                        {
                            $this->addRanking(
                                array(
                                    $this->cards[$a],
                                    $this->cards[$a],
                                    $this->cards[$b],
                                    $this->cards[$c],
                                    $this->cards[$d]
                                )
                            );
                        }
                    }

                }
            }
        }

    }

    function addRanking($cards, $suited=false)
    {
        $value = 1;

        foreach ($cards as $card)
        {
            $value *= $card->getRankValue();    
        }

        if ($suited) $value *= 59;

        $this->rankings[$value]=$this->done;
        $this->done++;
    }

    function twopairs()
    {
        for ($a = 12; $a >= 0; $a--)
        {
            for ($b = $a - 1; $b >= 0; $b--)
            {
                for ($c = 12; $c >= 0; $c--)
                {
                    if ($a != $b && $a != $c && $b != $c)
                    {
                        $this->addRanking(
                            array(
                                $this->cards[$a],
                                $this->cards[$a],
                                $this->cards[$b],
                                $this->cards[$b],
                                $this->cards[$c]
                            )
                        );
                    }
                }
            }
        }
    }

    function trips()
    {
        for ($a = 12; $a >= 0; $a--)
        {
            for ($b = 12; $b >= 0; $b--)
            {
                for ($c = $b - 1; $c >= 0; $c--)
                {
                    if ($a != $b && $a != $c)
                    {
                        $this->addRanking(
                            array(
                                $this->cards[$a],
                                $this->cards[$a],
                                $this->cards[$a],
                                $this->cards[$b],
                                $this->cards[$c]
                            )
                        );
                    }
                }
            }
        }
    }

    function flushes($suited=false)
    {
        for ($a = 12; $a >= 0; $a--)
        {
            for ($b = $a - 1; $b >= 0; $b--)
            {
                for ($c = $b - 1; $c >= 0; $c--)
                {
                    for ($d = $c - 1; $d >= 0; $d--)
                    {
                        for ($e = $d - 1; $e >= 0; $e--)
                        {
                            if ($a - 4 != $e)
                            {
                                $cards = array(
                                    $this->cards[$a],
                                    $this->cards[$b],
                                    $this->cards[$c],
                                    $this->cards[$d],
                                    $this->cards[$e]
                                );
                                
                                if ($cards[0]->getRankValue() * $cards[1]->getRankValue() * $cards[2]->getRankValue() * $cards[3]->getRankValue() * $cards[4]->getRankValue()  != 7770) // filter the awkward A5432 combination
                                {
                                    $this->addRanking($cards, $suited);
                                }                            
                            }
                        }
                    }
                }
            }
        }
    }

    function fullhouses()
    {
        for ($i = 12; $i >= 0; $i--)
        {
            for ($k = 12; $k >= 0; $k--)
            {
                if ($k != $i)
                {
                    $this->addRanking(
                        array(
                            $this->cards[$i],
                            $this->cards[$i],
                            $this->cards[$i],
                            $this->cards[$k],
                            $this->cards[$k]
                        )
                    );
                }
            }
        }
    }

    function quads()
    {
        for ($i = 12; $i >= 0; $i--)
        {
            for ($k = 12; $k >= 0; $k--)
            {
                if ($k != $i)
                {
                    $this->addRanking(
                        array(
                            $this->cards[$i],
                            $this->cards[$i],
                            $this->cards[$i],
                            $this->cards[$i],
                            $this->cards[$k]
                        )     
                    );

                }
            }
        }
    }

    function straights($suited=false)
    {        
        for ($i = 12; $i > 2; $i--)
        {            
            $cards = array(
                $this->cards[$i],
                $this->cards[$i-1],
                $this->cards[$i-2],
                $this->cards[$i-3]
            );

            if ($i > 3)
            {
                $cards[]=$this->cards[$i-4];
            }
            else
            {
                $cards[]=new card('A','d');
            }

            $this->addRanking($cards, $suited);
        }
    }

    private function getValueOfFive($cards)
    {
        $rankValue = $cards[0]->getRankValue();
        $suitValue = $cards[0]->getSuitValue();

        for ($i = 1; $i < 5; $i++)
        {
            $rankValue *= $cards[$i]->getRankValue();
            $suitValue *= $cards[$i]->getSuitValue();
        }

        $rank = $this->rankings[$rankValue];
        
        if ($suitValue === 115856201 || $suitValue === 147008443 || $suitValue === 229345007 || $suitValue === 418195493) // check if all five cards are the same suit
        {
            $rankValue *= 59;
            $temp = $this->rankings[$rankValue];
            
            if ($temp < $rank)
            {
                $rank = $temp;
            }
        }

        return $rank;
    }

    function getValue($cards)
    {   
        if (count($cards) < 5)
        {
            return false;
        }
        else
        {
            $count = 0;
            $this->highest = count($this->rankings) + 1;

            for ($a = count($cards) - 1; $a >= 0; $a--)
            {
                for ($b = $a - 1; $b >= 0; $b--)
                {
                    for ($c = $b - 1; $c >= 0; $c--)
                    {
                        for ($d = $c - 1; $d >= 0; $d--)
                        {
                            for ($e = $d - 1; $e >= 0; $e--)
                            {
                                $currentHand = array(
                                    $cards[$a],
                                    $cards[$b],
                                    $cards[$c],
                                    $cards[$d],
                                    $cards[$e]
                                );

                                $rank = $this->getValueOfFive($currentHand);

                                if ($rank < $this->highest) // lowest rank is best, 1 = Royal Flush.
                                {
                                    $this->highest = $rank;
                                    $this->bestHand = $currentHand;
                                }
                            }
                        }
                    }
                }
            }

            return $this->highest;
        }

    }

    static function sortCardsByRanks($cards) 
    {
        usort($cards, function($a, $b) use ($cards)
        {
            $aFreq = count(array_filter( $cards, function($object) use ($a) { return $object->getRank() == $a->getRank(); })); // count how many cards of that rank exist in the array
            $bFreq = count(array_filter( $cards, function($object) use ($b) { return $object->getRank() == $b->getRank(); }));

            //echo "aFreq: " .$a->getRank(). " - $aFreq, bFreq: " .$b->getRank(). " - $bFreq" . PHP_EOL;

            if ($bFreq > $aFreq || $aFreq > $bFreq)
            {
                return $bFreq > $aFreq;
            }
            else
            {
                return $a->getRankValue($a->getRank()) < $b->getRankValue($b->getRank());
            }
        });

        return $cards;
    }

    public function getHandName()
    {
        return $this->calculateHandName($this->highest, $this->bestHand);
    }

    private function calculateHandName($rank, $cards)
    {
        $name = "";
        $cards = self::sortCardsByRanks($cards);

        if (in_array($rank, array(10, 1609))) // When it's A5432, we need to bump the ace to the end of the array.
        {
            $card = array_shift($cards);
            $cards[]=$card;
        }

        if ($rank == 1)
        {
            $name = "Royal Flush.";
        }
        else if ($rank >= 2 && $rank <= 10)
        {
            $name = "Straight Flush, " . $cards[0]->getRankName() . " high.";
        
        }
        else if ($rank >= 11 && $rank <= 166)
        {
            $name = "Four of a Kind, " . $cards[0]->getRankName() . "s with a " . $cards[4]->getRankName() . " kicker.";
        }
        else if ($rank >= 167 && $rank <= 322)
        {
            $name = "Full House, " . $cards[0]->getRankName() . "s full of " . $cards[4]->getRankName() . "s.";
        }
        else if ($rank >= 323 && $rank <= 1599)
        {
            $name = "Flush, " . $cards[0]->getRankName() . " high - " . $cards[0]->getRankName() . ", " . $cards[1]->getRankName() . ", " . $cards[2]->getRankName() . ", " . $cards[3]->getRankName() . ", " . $cards[4]->getRankName() . ".";
        }
        else if ($rank >= 1600 && $rank <= 1609)
        {
            $name = "Straight, " . $cards[0]->getRankName() . " high - " . $cards[0]->getRankName() . ", " . $cards[1]->getRankName() . ", " . $cards[2]->getRankName() . ", " . $cards[3]->getRankName() . ", " . $cards[4]->getRankName() . ".";
        }
        else if ($rank >= 1610 && $rank <= 2467)
        {
            $name = "Three of a Kind, " . $cards[0]->getRankName() . "s with " . $cards[3]->getRankName() . " and " .  $cards[4]->getRankName() . " kickers.";
        }
        else if ($rank >= 2468 && $rank <= 3325)
        {
            $name = "Two pair, " . $cards[0]->getRankName() . "s and " . $cards[2]->getRankName() . "s with a " .  $cards[4]->getRankName() . " kicker.";
        }
        else if ($rank >= 3326 && $rank <= 6185)
        {
            $name = "One Pair, " . $cards[0]->getRankName() . "s with " . $cards[2]->getRankName() . ", " . $cards[3]->getRankName() . ", " . $cards[4]->getRankName() . " kickers.";
        }
        else if ($rank >= 6186)
        {
            $name = $cards[0]->getRankName() . " high - " . $cards[0]->getRankName() . ", " . $cards[1]->getRankName() . ", " . $cards[2]->getRankName() . ", " . $cards[3]->getRankName() . ", " . $cards[4]->getRankName() . ".";
        }

        return $name;
    }
}

?>