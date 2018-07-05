<?php
use PHPUnit\Framework\TestCase;

class deckTest extends TestCase
{
    public function testRankAndSuit()
    {
        $card = new card("A","d");

        $this->assertEquals(
            "A",
            $card->getRank()
        );

        $this->assertEquals(
            "d",
            $card->getSuit()
        );
        
        $this->assertEquals(
            "Ad",
            $card->toString()
        );   
    }

    public function testGetRanksAndgetSuits()
    {
        $ranks = array('2','3','4','5','6','7','8','9','T','J','Q','K','A');
        $suits = array('c','h','d','s');

        $this->assertEquals(
            $ranks,
            card::getRanks()
        );

        $this->assertEquals(
            $suits,
            card::getSuits()
        );
    }

    public function testIsValidSuit()
    {
        $this->assertEquals(
            false,
            card::isValidSuit('e')
        );

        $this->assertEquals(
            true,
            card::isValidSuit('d')
        );
    }

    public function testIsValidRank()
    {
        $this->assertEquals(
            false,
            card::isValidRank('B')
        );

        $this->assertEquals(
            true,
            card::isValidRank('Q')
        );
    }

    public function testGetRankValue()
    {
        $ranks = array(
            '2' => 2,
            '3' => 3,
            '4' => 5,
            '5' => 7,
            '6' => 9,
            '7' => 11,
            '8' => 13,
            '9' => 17,
            'T' => 19,
            'J' => 23,
            'Q' => 29,
            'K' => 31,
            'A' => 37,
        );

        foreach ($ranks as $key => $value)
        {
            $this->assertEquals(
                $value,
                card::getRankValue($key)
            );
        }

        $this->assertEquals(
            false,
            card::getRankValue("B")
        );
    }

    public function testGetSuitValue()
    {
        $suits = array(
            'c' => 41,
            'h' => 43,
            'd' => 47,
            's' => 53
        );

        foreach ($suits as $key => $value)
        {
            $this->assertEquals(
                $value,
                card::getSuitValue($key)
            );
        }

        $this->assertEquals(
            false,
            card::getSuitValue("b")
        );

    }
}

?>