<?php
use PHPUnit\Framework\TestCase;

class deckTest extends TestCase
{
    public function testDrawValidCard()
    {
        $deck = new deck();

        $this->assertInstanceOf(
            card::class,
            $deck->draw()
        );
    }

    public function testdoesContain()
    {
        $deck = new deck();
        $card = new card("2", "c");

        $this->assertEquals(
            true,
            $deck->contains($card)
        );
    }

    public function testdoesNotContain()
    {
        $deck = new deck();
        $card = $deck->draw();

        $this->assertEquals(
            false,
            $deck->contains($card)
        );
    }

    public function testEmptyDeck()
    {
        $deck = new deck();

        for ($i = 0; $i < 52; $i++)
        {
            $deck->draw();
        }

        $this->assertEquals(
            false,
            $deck->draw()
        );
    }

    public function testDrawSpecificNumber()
    {
        $deck = new deck();

        $this->assertEquals(
            7,
            count($deck->draw(7))
        );    
    }

    public function testEmptyShuffle()
    {
        $deck = new deck();
        $deck->draw(52);

        $this->assertEquals(
            false,
            $deck->shuffle()
        );
    }

    public function testDrawSpecificCard()
    {
        $deck = new deck();
        $card = new card("A", "d");

        $this->assertEquals(
            $card,
            $deck->card("A", "d")
        );

    }

    public function testShuffle()
    {
        $controlDeck = new deck();
        $testDeck = new deck();
        $testDeck->shuffle();
        $matches = true;

        while ($matches) // in case the decks match after shuffling!
        {
            for ($i = 0; $i < 52; $i++)
            {
                $card1 = $controlDeck->draw();
                $card2 = $testDeck->draw();
    
                if ($card1->getRank() != $card2->getRank() || $card1->getSuit() != $card2->getSuit())
                {
                    $matches = false;
                    break;
                }
            }

            if ($matches) $testDeck->shuffle();
        }

        $this->assertEquals(
            false,
            $matches
        );

    }
}

?>