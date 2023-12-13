<?php

use PHPUnit\Framework\TestCase;
use Si2k63\PokerHandEvaluator\Card;
use Si2k63\PokerHandEvaluator\Enums\Rank;
use Si2k63\PokerHandEvaluator\Enums\Suit;

class cardTest extends TestCase
{
    public function testRankAndSuit()
    {
        $card = new Card(Rank::Ace, Suit::Diamonds);

        $this->assertEquals(
            'A',
            $card->getRank()->getShortName()
        );

        $this->assertEquals(
            'd',
            $card->getSuit()->getShortName()
        );

        $this->assertEquals(
            'Ad',
            $card->toString()
        );

        $this->assertEquals(
            $card->getValue(),
            37 * 43
        );
    }
}
