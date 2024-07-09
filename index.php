<?php

require 'vendor/autoload.php';

use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Hand;
use Si2k63\PokerHandEvaluator\Card;
use Si2k63\PokerHandEvaluator\HighCardEvaluator;

$evaluator = new HighCardEvaluator();

$handOne = new Hand();
$handOne->addCard(new Card(Rank::Ace, Suit::Diamonds));
$handOne->addCard(new Card(Rank::King, Suit::Diamonds));
$handOne->addCard(new Card(Rank::Queen, Suit::Diamonds));
$handOne->addCard(new Card(Rank::Jack, Suit::Diamonds));
$handOne->addCard(new Card(Rank::Ten, Suit::Diamonds));


$handTwo = new Hand();
$handTwo->addCard(new Card(Rank::Ace, Suit::Spades));
$handTwo->addCard(new Card(Rank::Ace, Suit::Clubs));
$handTwo->addCard(new Card(Rank::Ace, Suit::Hearts));
$handTwo->addCard(new Card(Rank::Jack, Suit::Spades));
$handTwo->addCard(new Card(Rank::Jack, Suit::Clubs));

$handOneResult = $evaluator->evaluate($handOne);
$handTwoResult = $evaluator->evaluate($handTwo);
