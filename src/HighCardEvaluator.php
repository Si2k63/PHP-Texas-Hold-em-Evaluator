<?php

namespace Si2k63\PokerHandEvaluator;

use Si2k63\PokerHandEvaluator\Iterators\HighCardHandIterator;
use Si2k63\PokerHandEvaluator\Iterators\FourOfAKindHandIterator;
use Si2k63\PokerHandEvaluator\Iterators\FullHouseHandIterator;
use Si2k63\PokerHandEvaluator\Iterators\PairHandIterator;
use Si2k63\PokerHandEvaluator\Iterators\StraightHandIterator;
use Si2k63\PokerHandEvaluator\Iterators\ThreeOfAKindHandIterator;
use Si2k63\PokerHandEvaluator\Iterators\TwoPairHandIterator;

class HighCardEvaluator extends AbstractEvaluator
{
    public function __construct()
    {
        $this->addIterator(new StraightHandIterator(true));
        $this->addIterator(new FourOfAKindHandIterator());
        $this->addIterator(new FullHouseHandIterator());
        $this->addIterator(new HighCardHandIterator(true));
        $this->addIterator(new StraightHandIterator(false));
        $this->addIterator(new ThreeOfAKindHandIterator());
        $this->addIterator(new TwoPairHandIterator());
        $this->addIterator(new PairHandIterator());
        $this->addIterator(new HighCardHandIterator(false));
    }

    /**
     * Take an instance of a hand and its rank and return its full English name.
     * @param Hand $hand
     * @param int $rank
     *
     * @return string
     */
    protected function getName(Hand $hand, int $rank): string
    {
        $cards = $hand->sortByRank()->getCards();

        $firstCardName = $cards[0]->getRank()->name;
        $secondCardName = $cards[1]->getRank()->name;
        $thirdCardName = $cards[2]->getRank()->name;
        $fourthCardName = $cards[3]->getRank()->name;
        $fifthCardName = $cards[4]->getRank()->name;
        $article = $fifthCardName == 'Ace' ? 'an' : 'a';
        $kicker = $article . ' ' . $fifthCardName . ' kicker.';

        switch ($rank) {
            case 1:
                return 'Royal Flush';
            case in_array($rank, range(2, 9)):
                return 'Straight Flush, ' . $firstCardName . ' high.';

            case 10:
                return 'Straight Flush, ' . $secondCardName . ' high.';

            case in_array($rank, range(11, 166)):
                return 'Four of a Kind, ' . $firstCardName . 's with ' . $kicker;

            case in_array($rank, range(167, 322)):
                return 'Full House, ' . $firstCardName . 's full of ' . $fifthCardName . 's.';

            case in_array($rank, range(323, 1599)):
                return 'Flush, ' . $firstCardName . ' high - ' . $firstCardName . ', ' . $secondCardName . ', ' . $thirdCardName . ', ' . $fourthCardName . ', ' . $fifthCardName . '.';

            case in_array($rank, range(1600, 1608)):
                return 'Straight, ' . $firstCardName . ' high - ' . $firstCardName . ', ' . $secondCardName . ', ' . $thirdCardName . ', ' . $fourthCardName . ', ' . $fifthCardName . '.';

            case 1609:
                return 'Straight, ' . $secondCardName . ' high - ' . $secondCardName . ', ' . $thirdCardName . ', ' . $fourthCardName . ', ' . $fifthCardName . ', ' . $firstCardName . '.';

            case in_array($rank, range(1610, 2467)):
                return 'Three of a Kind, ' . $firstCardName . 's with ' . $fourthCardName . ' and ' .  $fifthCardName . ' kickers.';

            case in_array($rank, range(2468, 3325)):
                return 'Two pair, ' . $firstCardName . 's and ' . $thirdCardName . 's with ' . $kicker;

            case in_array($rank, range(3326, 6185)):
                return 'One Pair, ' . $firstCardName . 's with ' . $thirdCardName . ', ' . $fourthCardName . ', ' . $fifthCardName . ' kickers.';

            default:
                return $firstCardName . ' high - ' . $firstCardName . ', ' . $secondCardName . ', ' . $thirdCardName . ', ' . $fourthCardName . ', ' . $fifthCardName . '.';
        }
    }
}
