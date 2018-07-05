<?php

class evaluate
{
    var $rankings = array();

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
            $highest = count($this->rankings);

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
                                }
                            }
                        }
                    }
                }
            }

            return $highest;
        }

    }

    function getHandName($rank)
    {
        $name = "";

        if ($rank >= 1 && $rank <= 10)
        {
            switch ($rank)
            {
                case 1:
                    $name = "Royal Flush";
                    break;
                case 2:
                    $name = "King High Straight Flush";
                    break;
                case 3:
                    $name = "Queen High Straight Flush";
                    break;
                case 4:
                    $name = "Jack High Straight Flush";
                    break;
                case 5:
                    $name = "Ten High Straight Flush";
                    break;
                case 6:
                    $name = "Nine High Straight Flush";
                    break;
                case 7:
                    $name = "Eight High Straight Flush";
                    break;
                case 8:
                    $name = "Seven High Straight Flush";
                    break;
                case 9:
                    $name = "Six High Straight Flush";
                    break;
                case 10:
                    $name = "Five High Straight Flush";
                    break;
            }
        }
        else if ($rank >= 11 && $rank <= 166)
        {
            $name = "Four of a Kind";
        }
        else if ($rank >= 167 && $rank <= 322)
        {
            $name = "Full House";
        }
        else if ($rank >= 323 && $rank <= 1599)
        {
            $name = "Flush";
        }
        else if ($rank >= 1600 && $rank <= 1609)
        {
            $name = "Straight";
        }
        else if ($rank >= 1610 && $rank <= 2467)
        {
            $name = "Three of a Kind";
        }
        else if ($rank >= 2468 && $rank <= 3325)
        {
            $name = "Two Pair";
        }
        else if ($rank >= 3326 && $rank <= 6185)
        {
            $name = "One Pair";
        }
        else if ($rank >= 6186)
        {
            $name = "High Card";
        }

        return $name;
    }
}

?>