<?php

namespace Si2k63\PokerHandEvaluator\Enums;

enum Rank: int
{
    case Ace    = 37;
    case King   = 31;
    case Queen  = 29;
    case Jack   = 23;
    case Ten    = 19;
    case Nine   = 17;
    case Eight  = 13;
    case Seven  = 11;
    case Six    = 9;
    case Five   = 7;
    case Four   = 5;
    case Three  = 3;
    case Two    = 2;

    /**
     * Return the short English name of the rank (e.g. A, K, Q etc).
     * @return string
     */
    public function getShortName(): string
    {
        return match ($this) {
            Rank::Ace   => 'A',
            Rank::King  => 'K',
            Rank::Queen => 'Q',
            Rank::Jack  => 'J',
            Rank::Ten   => 'T',
            Rank::Nine  => '9',
            Rank::Eight => '8',
            Rank::Seven => '7',
            Rank::Six   => '6',
            Rank::Five  => '5',
            Rank::Four  => '4',
            Rank::Three => '3',
            Rank::Two   => '2'
        };
    }

    /**
     * Return a rank from a string.
     * @param String $rank
     * 
     * @return Rank
     */
    public static function fromString(String $rank): Rank
    {
        $cases = Rank::cases();

        foreach ($cases as $case) {
            if ($case->getShortName() === $rank) {
                return $case;
            }
        }

        throw new \Exception("Supplied rank does not exist.");
    }
}
