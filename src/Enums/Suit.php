<?php

namespace Si2k63\PokerHandEvaluator\Enums;

use Si2k63\PokerHandEvaluator\Traits\EnumExtended;

enum Suit: int
{
    use EnumExtended;

    case Hearts     = 41;
    case Diamonds   = 43;
    case Clubs      = 47;
    case Spades     = 53;

    /**
     * Return the short English name of the suit (e.g. h, d, c, s)
     * @return string
     */
    public function getShortName(): string
    {
        return match ($this) {
            Suit::Hearts    => 'h',
            Suit::Diamonds  => 'd',
            Suit::Clubs     => 'c',
            Suit::Spades    => 's',
        };
    }
}
