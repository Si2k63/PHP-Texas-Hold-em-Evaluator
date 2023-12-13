<?php
require __DIR__ . "/../vendor/autoload.php";
/**
 * Example 1 - Deal two random hands and determine a winner.
 */

use Si2k63\PokerHandEvaluator\Deck;
use Si2k63\PokerHandEvaluator\Evaluator;
use Si2k63\PokerHandEvaluator\Hand;

$deck = new Deck();
$deck->shuffle();

$firstHand = Hand::fromArray($deck->drawCards(5));
$secondHand = Hand::fromArray($deck->drawCards(5));

$evaluator = new Evaluator();

$firstResult = $evaluator->evaluate($firstHand);
$secondResult = $evaluator->evaluate($secondHand);

if ($firstResult->getRank() < $secondResult->getRank()) {
    echo 'First hand is the winner with: ' . $firstResult->getName() . PHP_EOL;
} else {
    if ($firstResult->getRank() == $secondResult->getRank()) {
        echo "It's a tie! Both players have: " . $firstResult->getName() . PHP_EOL;
    } else {
        echo 'Second hand is the winner with: ' . $secondResult->getName() . PHP_EOL;
    }
}
