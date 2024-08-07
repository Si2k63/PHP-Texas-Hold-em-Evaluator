# PHP Texas Hold'em Hand Evaluator

## Getting Started

Simply install the package through composer using the command:

```
composer require si2k63/php-texas-hold-em-evaluator
```

## Overview

A surprisingly fast Texas Hold'em hand evaluator written in PHP. Draw cards from the deck factory class (or instantiate specific ones) and pass them to the evaluate class to determine their rank in the form of an integer or a full text description.

### Deck Class

This is a factory class that will generate, shuffle and deal a deck of 52 cards.

#### Instantiating the class:

    $deck = new Deck();

#### Shuffling the deck:

    $deck->shuffle();

#### Drawing a card:

    $card = $deck->draw();

#### Drawing a specific card

    $card = $deck->card(Rank::Ace, Suit::Diamonds);

#### Checking if a card is present in the deck:

    if ($deck->contains(new Card(Rank::Ace, Suit::Diamonds)) {
    	echo "The Ad is in the deck.";
    } else {
    	echo "The Ad is not in the deck.";
    }

### Card Class

#### Instantiating a Card

    $card = new Card(Rank::Ace, Suit::Hearts);

#### Getting the unique value of a card

    $card->getValue();

### Evaluator Class

The evaluator class is an abstract class that accepts hand iterator classes through its add iterator method.

Currently there is a High Card Evaluator that extends this class and passes in the relevant iterator classes through its constructor.

#### Instantiating the high card class:

    $evaluator = new HighCardEvaluator();

#### Determining the rank of a collection of five cards

    $hand = Hand::fromArray([
    	new Card(Rank::Ace, Suit::Clubs),
    	new Card(Rank::Ace, Suit::Spades),
    	new Card(Rank::Ace, Suit::Diamonds),
    	new Card(Rank::King, Suit::Clubs),
    	new Card(Rank::Jack, Suit::Hearts)
    ]);

    $evaluator = new HighCardEvaluator();
    $result = $evaluator->evaluate($hand);

    echo "Rank:" . $result->getRanking() . PHP_EOL;
    echo "Name: $name" . $result->getName() . PHP_EOL;

#### Extending the Evaluator Class

It is possible to extend the evaluator class and make your own evaluator (e.g a low card hand evaluator for games like 2-7 Triple Draw).

You'd need to implement your own hand iterator, which passes low card hands in order of rank (highest to lowest) into your class.

## Additional Examples

The examples directory contains two example scripts of how this hand evaluator could be used.

#### Example 1 - hand.php

Deals two random five card hands and compares them to determine the winning hand.

#### Example 2 - equity.php

Compares two starting hands from Texas Hold'em and deals all possible boards to determine what percentaege of the time each hand wins.

## Requirements

- PHP 8.1 (As enums are used for the Ranks and Suits)
- Composer

## How It Works

The library is built on the principle that the multiplication of two prime numbers always results in a number that cannot be produced by multiplying any other two numbers.

Each card's rank and suit are assigned a unique prime number in ascending order.

On initialisation the evaluation class enumerates through all 7462 possible groupings of poker hands from best to worst, calculating a unique identifier for each of them.

e.g. A \* K \* Q \* J \* T = 14535931 (Ace High Straight)

Those unique identifiers are stored in a rankings array, with the unique identifier's position in the array being used as the basis for its rank. The unique id for A Royal Flush will be at position 0 in the array, while the unique id for 7 5 4 3 2 of differing suits (the worst possible 5 card combination) will be at the last position.

In cases of where a hand containing cards that are all the same suit (e.g. straight flushes and flushes) the product is multiplied by the next available prime number (59) to ensure a unique number is produced.

e.g. A \* K \* Q \* J \* T \* 59 = 857619929 (A Royal Flush)

This allows the evaluator to distinguish between flush and non-flush hands.

Then, when a hand is passed to the class for evaluation, the unique identifier for all possible five card combinations of cards is calculated and checked against the rankings table to determine which has the highest rank.

#### A Few Benefits of Using Prime Numbers

1. The order of the cards does not matter when determining their rank (e.g. K A J Q T produces the same result as A K Q J T).
2. It's pretty quick once the rankings array is populated all we're doing is finding the key of an integer stored in that array.

## References

[http://suffe.cool/poker/7462.html](http://suffe.cool/poker/7462.html)

[https://en.wikipedia.org/wiki/Poker_probability](https://en.wikipedia.org/wiki/Poker_probability)
