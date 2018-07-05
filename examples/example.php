<?php

$time_start = microtime(true);
require "../vendor/autoload.php";

// create a deck and shuffle it
$deck = new deck();
$deck->shuffle();

// deal five cards to player one
$playerOne = array();
$playerOne[]=$deck->draw();
$playerOne[]=$deck->draw();
$playerOne[]=$deck->draw();
$playerOne[]=$deck->draw();
$playerOne[]=$deck->draw();

// deal five cards to player two
$playerTwo = array();
$playerTwo[]=$deck->draw();
$playerTwo[]=$deck->draw();
$playerTwo[]=$deck->draw();
$playerTwo[]=$deck->draw();
$playerTwo[]=$deck->draw();


// determine the strength of both hands
$evaluate = new evaluate();
$playerOneRank = $evaluate->getValue($playerOne);
$playerTwoRank = $evaluate->getValue($playerTwo);


// display the winner
if ($playerOneRank < $playerTwoRank)
{
    echo "Player one is the winner with: " .  $evaluate->getHandName($playerOneRank) . PHP_EOL;
    echo "Player two is the loser with: " .  $evaluate->getHandName($playerTwoRank) . PHP_EOL;   
}
else
{
    if ($playerOneRank == $playerTwoRank)
    {
        echo "It's a tie! Both players have: " . $evaluate->getHandName($playerOneRank) . PHP_EOL;
    }
    else
    {
        echo "Player two is the winner with a: " .  $evaluate->getHandName($playerTwoRank) . PHP_EOL;
        echo "Player one is the loser with a: " .  $evaluate->getHandName($playerOneRank) . PHP_EOL;
     }
}

$time_end = microtime(true);
echo "Hand dealt and evaluated in " . ($time_end - $time_start) . " seconds.";

?>