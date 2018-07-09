<?php

$time_start = microtime(true);
require "../vendor/autoload.php";

/* Equity Example:
Deal all possible boards and determine what percentage of the time each hand wins.
This example takes about 4 minutes to run on PHP 5.3, and about 2 minutes on PHP 7.
*/

// create a deck and shuffle it
$deck = new deck();

$hand1 = array(
    $deck->card("A","d"),
    $deck->card("K","d")
);

$hand2 = array(
    $deck->card("5","s"),
    $deck->card("5","c")
);

$cards = $deck->draw(48);
$evaluate = new evaluate();

$hand1wins = 0;
$hand2wins = 0;
$draws = 0;
$count = 0;

for ($a = 0; $a < count($cards); $a++)
{
    for ($b = $a + 1; $b < count($cards); $b++)
    {
        for ($c = $b + 1; $c < count($cards); $c++)
        {
            for ($d = $c + 1; $d < count($cards); $d++)
            {
                for ($e = $d + 1; $e < count($cards); $e++)
                {
                    if ($a != $b && $a != $c && $a != $d && $a != $e && $b != $c && $b != $d && $b != $e && $c != $d && $c != $e && $d != $e)
                    {
                        $hand1cards = array(
                            $hand1[0],
                            $hand1[1],
                            $cards[$a],
                            $cards[$b],
                            $cards[$c],
                            $cards[$d],
                            $cards[$e]
                        );

                        $hand2cards = array(
                            $hand2[0],
                            $hand2[1],
                            $cards[$a],
                            $cards[$b],
                            $cards[$c],
                            $cards[$d],
                            $cards[$e]
                        );

                        $hand1rank = $evaluate->getValue($hand1cards);
                        $hand2rank = $evaluate->getValue($hand2cards);

                        if ($hand1rank == $hand2rank)
                        {
                            $draws++;
                        }
                        else
                        {
                            if ($hand1rank > $hand2rank)
                            {
                                $hand2wins++;
                            }
                            else
                            {
                                $hand1wins++;
                            }
                        }

                        $count++;
                    }
                }
            }
        }
    }
}

$hand1wins = round(($hand1wins + $draws / 2) / $count * 100, 3);
$hand2wins = round(($hand2wins + $draws / 2) / $count * 100, 3);

echo "Hand one wins $hand1wins % of the time." . PHP_EOL;
echo "Hand two wins $hand2wins % of the time" . PHP_EOL;
echo "$count total boards tested." . PHP_EOL;

$time_end = microtime(true);
echo "Hand dealt and evaluated in " . ($time_end - $time_start) . " seconds.";

?>