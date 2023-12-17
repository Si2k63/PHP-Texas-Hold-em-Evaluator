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

echo 'Hand 1:' . $firstHand->toString() . PHP_EOL;
echo 'Hand 2:' . $secondHand->toString() . PHP_EOL;

if ($firstResult->getRanking() < $secondResult->getRanking()) {
    echo 'First hand is the winner with: ' . $firstResult->getName() . PHP_EOL;
} else {
    if ($firstResult->getRanking() == $secondResult->getRanking()) {
        echo "It's a tie! Both players have: " . $firstResult->getName() . PHP_EOL;
    } else {
        echo 'Second hand is the winner with: ' . $secondResult->getName() . PHP_EOL;
    }
}
