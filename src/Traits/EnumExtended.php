<?php

namespace Si2k63\PokerHandEvaluator\Traits;

trait EnumExtended
{
    /**
     * Return all cases excluding any contained in the supplied array.
     *
     * @param array $excludedCases
     *
     * @return array
     */
    public static function excluding(array $excludedCases): array
    {
        $excludedCases = array_map(fn ($excluded) => $excluded->value, $excludedCases);
        return array_filter(self::cases(), fn ($item) => !in_array($item->value, $excludedCases));
    }

    /**
     * Return a slice of the Enum's cases
     *
     * @param int $start
     * @param int $end
     *
     * @return array
     */
    public static function slice(int $start, int $end = null): array
    {
        $cases = self::cases();

        if ($start > count($cases)) {
            return [];
        }

        return array_slice($cases, $start, $end);
    }

    /**
     * Return an enum from the supplied shortname.
     * @param String $shortName
     *
     * @return Enum
     */
    public static function fromString(String $shortName): Enum
    {
        $cases = self::cases();

        foreach ($cases as $case) {
            if ($case->getShortName() === $shortName) {
                return $case;
            }
        }

        throw new \Exception("Supplied " . get_called_class() . " does not exist.");
    }

    /**
     * get the short text name for an enum.
     *
     * @return string
     */
    public function getShortName(): string
    {
        throw new \Exception(get_called_class() . " has not implemented a getShortName method");
    }

}