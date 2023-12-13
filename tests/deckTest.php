<?php

use PHPUnit\Framework\TestCase;
use Si2k63\PokerHandEvaluator\Card;
use Si2k63\PokerHandEvaluator\Deck;
use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;

class deckTest extends TestCase
{
    public function testDrawValidCard()
    {
        $deck = new Deck();
        $card = $deck->drawCards(1)[0];


        $this->assertInstanceOf(
            Card::class,
            $card
        );
    }

    public function testdoesContain()
    {
        $deck = new Deck();
        $card = new Card(Rank::Two, Suit::Clubs);

        $this->assertEquals(
            true,
            $deck->contains($card)
        );
    }

    public function testdoesNotContain()
    {
        $deck = new deck();
        $card = $deck->drawCards()[0];

        $this->assertEquals(
            false,
            $deck->contains($card)
        );
    }

    public function testEmptyDeck()
    {
        $deck = new Deck();

        for ($i = 0; $i < 52; $i++) {
            $deck->drawCards(1);
        }

        $this->expectException(\Exception::class);
        $deck->drawCards(1);
    }

    public function testDrawSpecificNumber()
    {
        $deck = new Deck();

        $this->assertEquals(
            7,
            count($deck->drawCards(7))
        );
    }

    public function testEmptyShuffle()
    {
        $deck = new Deck();
        $deck->drawCards(52);

        $this->expectException(\Exception::class);
        $deck->shuffle();
    }

    public function testDrawSpecificCard()
    {
        $deck = new Deck();

        $rank = Rank::King;
        $suit = Suit::Hearts;

        $card = $deck->getCard($rank, $suit);

        $this->assertEquals(
            $card->getRank(),
            $rank
        );

        $this->assertEquals(
            $card->getSuit(),
            $suit
        );
    }

    public function testShuffle()
    {
        $matches = true;
        $controlDeck = new Deck();
        $testDeck = new Deck();
        $testDeck->shuffle();

        $controlCards = $controlDeck->drawCards(52);
        $testCards = $testDeck->drawCards(52);

        for ($i = 0; $i < 52; $i++) {
            if ($controlCards[$i]->toString() !== $testCards[$i]->toString()) {
                $matches = false;
                break;
            }
        }

        $this->assertEquals(
            false,
            $matches
        );
    }
}
