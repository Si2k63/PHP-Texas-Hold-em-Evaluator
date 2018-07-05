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
$playerOneHand = $evaluate->getHandName();

$playerTwoRank = $evaluate->getValue($playerTwo);
$playerTwoHand = $evaluate->getHandName();

// display the winner
if ($playerOneRank < $playerTwoRank)
{
    echo "Player one is the winner with: $playerOneHand" . PHP_EOL;
    echo "Player two is the loser with: $playerTwoHand" . PHP_EOL;   
}
else
{
    if ($playerOneRank == $playerTwoRank)
    {
        echo "It's a tie! Both players have: $playerOneHand" . PHP_EOL;
    }
    else
    {
        echo "Player two is the winner with: $playerTwoHand" . PHP_EOL;
        echo "Player one is the loser with: $playerOneHand" . PHP_EOL;   
     }
}

$time_end = microtime(true);
echo "Hand dealt and evaluated in " . ($time_end - $time_start) . " seconds.";

?>