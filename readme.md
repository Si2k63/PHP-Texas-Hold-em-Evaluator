# PHP Texas Hold'em Hand Evaluator

## Overview

A surprisingly fast Texas Hold'em hand evaluator written in PHP. Draw cards from the deck factory class (or instantiate specific ones) and pass them to the evaluate class to determine their rank in the form of an integer or a full text description.

## Getting Started

There are three main classes included in this project: card, deck and evaluate.

### Deck Class
This is a factory class that will generate, shuffle and deal a deck of 52 cards.


#### Instantiating the class:
	$deck = new deck();


#### Shuffling the deck:
	$deck->shuffle();


#### Drawing a card:
	$card = $deck->draw();

#### Drawing a specific card
	$card = $deck->card("A", "d");

#### Checking if a card is present in the deck:
    if ($deck->contains(new card('A', 'd'))
	{
		echo "The Ad is in the deck.";
	}
	else
	{
		echo "The Ad is not in the deck.";
	}

### Card Class

#### Getting the full English name of the card:
	$card->getRankName();

### Evaluate Class

#### Instantiating the class:
	$evaluate = new evaluate();

#### Determining the rank of a collection of five cards
	$deck = new deck();

	$cards = array(
		$deck->card('A', 'd'),
		$deck->card('K', 'c'),
		$deck->card('K', 's'),
		$deck->card('A', 'h'),
		$deck->card('A', 'c')
	);
 
	$evaluate = new evaluate();
	$rank = $evaluate->getValue($cards);
	$name = $evaluate->getHandName();

	echo "Rank: $rank" . PHP_EOL;
	echo "Name: $name" . PHP_EOL;
	
#### Comparing two hands:
	$evaluate = new evaluate();
	$deck = new deck();

	$hand1 = array(
		$deck->card('A', 'd'),
		$deck->card('K', 'c'),
		$deck->card('K', 's'),
		$deck->card('A', 'h'),
		$deck->card('A', 'c')
	);

	$hand2 = array(
		$deck->card('A', 'd'),
		$deck->card('Q', 'c'),
		$deck->card('J', 's'),
		$deck->card('T', 'h'),
		$deck->card('K', 'c')
	);

	$evaluate = new evaluate();

	$hand1rank = $evaluate->getValue($hand1);
	$hand2rank = $evaluate->getValue($hand2);

	if ($hand1rank < $hand2rank)
	{
		echo "Hand one wins.";
	}
	else
	{
		if ($hand1rank == $hand2rank)
		{
			echo "It's a tie!";
		}
		else
		{
			echo "Hand two wins.";
		}
	}

## Requirements

PHP 5.3.0 or greater is required for the use of these libraries, due to the inclusion of the "use" identifier in usort callbacks in the evaluation class. Due to array optimisations made in PHP 7, this class does perform faster on PHP 7 by upto about 50%. 

PHPUnit required for running tests (included in repository).

## How It Works

The library is built on the principle that the multiplication of two prime numbers always results in a number that cannot be produced by multiplying any other two numbers (With the exception of 1 x n). 

Each card's rank and suit are assigned a unique prime number in ascending order. Below is an overview of the ranks and suits and their associated prime numbers.

##### Ranks

- Two = 2
- Three = 3
- Four = 5
- Five = 7
- Six = 9
- Seven = 11
- Eight = 13
- Nine = 17
- Ten = 19
- Jack = 23
- Queen = 29
- King = 31
- Ace = 37 

##### Suits

- Clubs = 41
- Hearts = 43
- Diamonds = 47
- Spades = 53


On initialisation the evaluation class enumerates through all 7462 possible poker hands from best to work, calculating a unique identifier for each of them. 

e.g. A * K * Q * J * T = 14535931 (Ace High Straight)

Those unique identifiers are stored in a rankings array, with the unique identifier's position in the array being used as the basis for its rank. The unique id for A Royal Flush will be at position 0 in the array, while the unique id for 7 5 4 3 2 of differing suits (the worst possible 5 card combination) will be at the last position.

In cases of hands containing cards that are all the same suit (e.g. straight flushes and flushes) the product is multiplied by the next available prime number (59) to ensure a unique number is produced.

e.g. A * K * Q * J * T * 59 = 857619929 (A Royal Flush)

Then, when an array of cards is passed to the class for evaluation, the unique identifier for all possible five card combinations of cards is calculated and checked against the rankings table to determine which has the highest rank.

#### Benefits of Using Prime Numbers

1. The order of the cards does not matter when determining their rank (e.g. K A J Q T produces the same result as A K Q J T).
2. It's really easy to identify when five cards are the same since Diamond⁵, Heart⁵, Club⁵ and Spade⁵ produce unique numbers that cannot be matched by any other combination of five suits.
3. It's pretty quick, since once the rankings array is populated all we're doing is finding the key of an integer stored in that array.
4. We can generate the full English names for hands on the fly.

## References
[http://suffe.cool/poker/7462.html](http://suffe.cool/poker/7462.html)

[https://en.wikipedia.org/wiki/Poker_probability](https://en.wikipedia.org/wiki/Poker_probability)