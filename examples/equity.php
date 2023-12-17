<?php

/* Equity Example:
 * Take two, two card starting hands, deal all possible 5 card hand combinations that include them, and determine what percentage of the time each hand wins.
*/

require __DIR__ . '/../vendor/autoload.php';

use Si2k63\PokerHandEvaluator\Deck;
use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Evaluator;
use Si2k63\PokerHandEvaluator\Hand;

$time_start = microtime(true);

$deck = new Deck();

$startingHandOne = [
    $deck->getCard(Rank::Ace, Suit::Diamonds),
    $deck->getCard(Rank::King, Suit::Diamonds)
];

$startingHandTwo = [
    $deck->getCard(Rank::Five, Suit::Clubs),
    $deck->getCard(Rank::Five, Suit::Spades)
];

$cards = $deck->drawCards(48);
$evaluate = new Evaluator();

$hand1wins = 0;
$hand2wins = 0;
$draws = 0;
$count = 0;

for ($a = 0; $a < count($cards); $a++) {
    for ($b = $a + 1; $b < count($cards); $b++) {
        for ($c = $b + 1; $c < count($cards); $c++) {

            $hand1 = Hand::fromArray([
                ...$startingHandOne,
                $cards[$a],
                $cards[$b],
                $cards[$c],
            ]);

            $hand2 = Hand::fromArray([
                ...$startingHandTwo,
                $cards[$a],
                $cards[$b],
                $cards[$c],
            ]);

            try {
                $hand1rank = $evaluate->evaluate($hand1)->getRanking();
            } catch (\Exception $e) {
                die($hand1->toString() . ':' . $e);
            }

            try {
                $hand2rank = $evaluate->evaluate($hand2)->getRanking();
            } catch (\Exception $e) {
                die($hand2->toString() . ':' . $e);
            }

            if ($hand1rank == $hand2rank) {
                $draws++;
            } else {
                if ($hand1rank > $hand2rank) {
                    $hand2wins++;
                } else {
                    $hand1wins++;
                }
            }

            $count++;
        }
    }
}

$hand1wins = round(($hand1wins + $draws / 2) / $count * 100, 3);
$hand2wins = round(($hand2wins + $draws / 2) / $count * 100, 3);

echo "Hand one wins $hand1wins % of the time." . PHP_EOL;
echo "Hand two wins $hand2wins % of the time" . PHP_EOL;
echo "$count total hands dealt." . PHP_EOL;

$time_end = microtime(true);
echo "Hand dealt and evaluated in " . ($time_end - $time_start) . " seconds.";
