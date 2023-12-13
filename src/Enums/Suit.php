<?php

namespace Si2k63\PokerHandEvaluator\Enums;

enum Suit: int
{
    case Hearts     = 41;
    case Diamonds   = 43;
    case Clubs      = 47;
    case Spades     = 53;

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
