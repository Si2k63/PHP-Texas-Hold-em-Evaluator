<?php

use PHPUnit\Framework\TestCase;
use Si2k63\PokerHandEvaluator\Card;
use Si2k63\PokerHandEvaluator\Deck;
use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;
use Si2k63\PokerHandEvaluator\Evaluator;
use Si2k63\PokerHandEvaluator\Hand;

class evaluateTest extends TestCase
{
    public function testHandNames()
    {
        $testHands = [
            'Royal Flush.' => [
                new Card(Rank::Ace, Suit::Diamonds),
                new Card(Rank::King, Suit::Diamonds),
                new Card(Rank::Queen, Suit::Diamonds),
                new Card(Rank::Jack, Suit::Diamonds),
                new Card(Rank::Ten, Suit::Diamonds)
            ],
            'Straight Flush, Five high.' => [
                new Card(Rank::Ace, Suit::Diamonds),
                new Card(Rank::Two, Suit::Diamonds),
                new Card(Rank::Three, Suit::Diamonds),
                new Card(Rank::Five, Suit::Diamonds),
                new Card(Rank::Four, Suit::Diamonds),
            ],
            'Four of a Kind, Kings with a Queen kicker.' => [
                new Card(Rank::King, Suit::Diamonds),
                new Card(Rank::King, Suit::Clubs),
                new Card(Rank::King, Suit::Spades),
                new Card(Rank::King, Suit::Hearts),
                new Card(Rank::Queen, Suit::Diamonds)
            ],
            'Full House, Queens full of Jacks.' => [
                new Card(Rank::Queen, Suit::Diamonds),
                new Card(Rank::Queen, Suit::Clubs),
                new Card(Rank::Jack, Suit::Spades),
                new Card(Rank::Jack, Suit::Hearts),
                new Card(Rank::Queen, Suit::Spades)
            ],
            'Flush, Ace high - Ace, Eight, Five, Four, Two.' => [
                new Card(Rank::Ace, Suit::Diamonds),
                new Card(Rank::Eight, Suit::Diamonds),
                new Card(Rank::Five, Suit::Diamonds),
                new Card(Rank::Four, Suit::Diamonds),
                new Card(Rank::Two, Suit::Diamonds)
            ],
            'Straight, Jack high - Jack, Ten, Nine, Eight, Seven.' => [
                new Card(Rank::Jack, Suit::Diamonds),
                new Card(Rank::Ten, Suit::Clubs),
                new Card(Rank::Nine, Suit::Spades),
                new Card(Rank::Eight, Suit::Hearts),
                new Card(Rank::Seven, Suit::Diamonds)
            ],
            'Straight, Five high - Five, Four, Three, Two, Ace.' => [
                new Card(Rank::Ace, Suit::Diamonds),
                new Card(Rank::Two, Suit::Clubs),
                new Card(Rank::Five, Suit::Diamonds),
                new Card(Rank::Three, Suit::Hearts),
                new Card(Rank::Four, Suit::Spades)
            ],
            'Three of a Kind, Fives with Ace and Eight kickers.' => [
                new Card(Rank::Five, Suit::Diamonds),
                new Card(Rank::Five, Suit::Clubs),
                new Card(Rank::Five, Suit::Spades),
                new Card(Rank::Eight, Suit::Hearts),
                new Card(Rank::Ace, Suit::Clubs)
            ],
            'Two pair, Aces and Fives with a Jack kicker.' => [
                new Card(Rank::Ace, Suit::Diamonds),
                new Card(Rank::Ace, Suit::Clubs),
                new Card(Rank::Five, Suit::Spades),
                new Card(Rank::Five, Suit::Diamonds),
                new Card(Rank::Jack, Suit::Hearts),
            ],
            'One Pair, Aces with Five, Three, Two kickers.' => [
                new Card(Rank::Ace, Suit::Diamonds),
                new Card(Rank::Ace, Suit::Clubs),
                new Card(Rank::Two, Suit::Spades),
                new Card(Rank::Five, Suit::Diamonds),
                new Card(Rank::Three, Suit::Hearts),
            ]
        ];

        $evaluator = new Evaluator();

        foreach ($testHands as $testName => $testHand) {
            $result = $evaluator->evaluate(Hand::fromArray($testHand));
            $this->assertEquals(
                $testName,
                $result->getName()
            );
        };
    }

    public function testAllHands()
    {
        // hands.json file generated by hand using list at: http://suffe.cool/poker/7462.html    
        $evaluator = new Evaluator();

        $suits = [
            Suit::Clubs,
            Suit::Diamonds,
            Suit::Hearts,
            Suit::Spades,
            Suit::Clubs
        ];

        $hands = json_decode(file_get_contents("tests/hands.json"));

        for ($i = 0; $i < count($hands); $i++) {
            $hand = new Hand();

            for ($k = 0; $k < count($hands[$i]->cards); $k++) {
                if ($hands[$i]->suited) {
                    $suit = Suit::Diamonds;
                } else {
                    $suit = $suits[$k];
                }

                $hand->addCard(new Card(Rank::fromString($hands[$i]->cards[$k]), $suit));
            }

            $result = $evaluator->evaluate($hand);

            $this->assertEquals(
                $i + 1,
                $result->getRanking()
            );

            $this->assertNotEquals(
                0,
                strlen($result->getName())
            );
        }
    }
}
