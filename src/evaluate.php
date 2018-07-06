<?php

class evaluate
{
    var $rankings = array();
    var $lastResult = "";

    function __construct()
    {
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
        $ranks = card::getRanks();

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
                            $value = card::getRankValue($ranks[$a]) * card::getRankValue($ranks[$a]) * card::getRankValue($ranks[$b]) * card::getRankValue($ranks[$c])* card::getRankValue($ranks[$d]);;
                            $this->rankings[]=$value;
                        }
                    }

                }
            }
        }

    }

    function twopairs()
    {
        $ranks = card::getRanks();

        for ($a = 12; $a >= 0; $a--)
        {
            for ($b = $a - 1; $b >= 0; $b--)
            {
                for ($c = 12; $c >= 0; $c--)
                {
                    if ($a != $b && $a != $c && $b != $c)
                    {
                        $value = card::getRankValue($ranks[$a]) * card::getRankValue($ranks[$a]) * card::getRankValue($ranks[$b]) * card::getRankValue($ranks[$b]) * card::getRankValue($ranks[$c]);
                        $this->rankings[]=$value;
                    }
                }
            }
        }
    }

    function trips()
    {
        $ranks = card::getRanks();

        for ($a = 12; $a >= 0; $a--)
        {
            for ($b = 12; $b >= 0; $b--)
            {
                for ($c = $b - 1; $c >= 0; $c--)
                {
                    if ($a != $b && $a != $c)
                    {
                        $value = card::getRankValue($ranks[$a]) * card::getRankValue($ranks[$a]) * card::getRankValue($ranks[$a]) * card::getRankValue($ranks[$b]) * card::getRankValue($ranks[$c]);
                        $this->rankings[]=$value;
                    }
                }
            }
        }
    }

    function flushes($suited=false)
    {
        $ranks = card::getRanks();

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
                                $value = card::getRankValue($ranks[$a]) * card::getRankValue($ranks[$b]) * card::getRankValue($ranks[$c]) * card::getRankValue($ranks[$d]) * card::getRankValue($ranks[$e]);
                                
                                if ($value != 7770) // filter the awkward A5432 combination
                                {
                                    if ($suited) $value *= 59; // multiplied by next prime number in the sequence to distinguish from non-suited 5 card combinations.
                                    $this->rankings[]=$value;
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
        $ranks = card::getRanks();

        for ($i = 12; $i >= 0; $i--)
        {
            for ($k = 12; $k >= 0; $k--)
            {
                if ($k != $i)
                {
                    $value = card::getRankValue($ranks[$i]) * card::getRankValue($ranks[$i]) * card::getRankValue($ranks[$i]) * card::getRankValue($ranks[$k]) * card::getRankValue($ranks[$k]);
                    $this->rankings[]=$value;
                }
            }
        }
    }

    function quads()
    {
        $ranks = card::getRanks();

        for ($i = 12; $i >= 0; $i--)
        {
            for ($k = 12; $k >= 0; $k--)
            {
                if ($k != $i)
                {
                    $value = card::getRankValue($ranks[$i]) * card::getRankValue($ranks[$i]) * card::getRankValue($ranks[$i]) * card::getRankValue($ranks[$i]) * card::getRankValue($ranks[$k]);
                    $this->rankings[]=$value;
                }
            }
        }
    }

    function straights($suited=false)
    {
        $ranks = card::getRanks();
        
        for ($i = 12; $i > 2; $i--)
        {
            $value = card::getRankValue($ranks[$i]) * card::getRankValue($ranks[$i-1]) * card::getRankValue($ranks[$i-2]) * card::getRankValue($ranks[$i-3]);

            if ($i > 3)
            {
                $value *= card::getRankValue($ranks[$i-4]);
            }
            else
            {
                $value *= card::getRankValue('A');
            }

            if ($suited) $value *= 59;
            $this->rankings[]=$value;
        }
    }

    private function getValueOfFive($cards)
    {
        if (count($cards) != 5)
        {
            return false;
        }
        else
        {
            $rankValue = card::getRankValue($cards[0]->getRank());
            $suitValue = card::getSuitValue($cards[0]->getSuit());

            for ($i = 1; $i < 5; $i++)
            {
                $rankValue *= card::getRankValue($cards[$i]->getRank());
                $suitValue *= card::getSuitValue($cards[$i]->getSuit());                
            }

            $suits = array(
                115856201,  // clubs
                147008443,  // hearts
                229345007,  // diamonds
                418195493   // spades
            );

            $rank = array_search($rankValue, $this->rankings, true);            
            
            if ($rank !== false)
            {

                if (in_array($suitValue, $suits)) 
                {
                    $rankValue *= 59;

                    $temp = array_search($rankValue, $this->rankings, true); 
                    
                    if ($temp !== false && $temp < $rank)
                    {
                        $rank = $temp;
                    }
                }
                return $rank + 1;
            }
            else
            {
                return false;
            }

        }
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
            $highest = count($this->rankings) + 1;

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
                                $currentHand = array();
                                $currentHand[]=$cards[$a];
                                $currentHand[]=$cards[$b];
                                $currentHand[]=$cards[$c];
                                $currentHand[]=$cards[$d];
                                $currentHand[]=$cards[$e];
                                $rank = $this->getValueOfFive($currentHand);

                                if ($rank < $highest) // lowest rank is best, 1 = Royal Flush.
                                {
                                    $highest = $rank;
                                    $this->lastResult = $this->calculateHandName($rank, $currentHand);
                                }
                            }
                        }
                    }
                }
            }


            return $highest;
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

    function getHandName()
    {
        return $this->lastResult;
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