<?php

/**
 * @author Abdeslam Gacemi <abdobling@gmail.com>
 */

namespace Abdeslam\KMBT;

use InvalidArgumentException;

/**
 * @method static string formatForK($value, int $precision = 2, bool $literal = false, string $glue = '')
 * @method static string formatForM($value, int $precision = 2, bool $literal = false, string $glue = '')
 * @method static string formatForB($value, int $precision = 2, bool $literal = false, string $glue = '')
 * @method static string formatForT($value, int $precision = 2, bool $literal = false, string $glue = '')
 */
class KMBT
{
    /** @var array */
    protected static $baseFormulas = ['K', 'M', 'B', 'T'];

    /** @var array */
    protected static $formulas = [
        "K" => [
            'literal' => 'thousand',
            'divisor' => 10**3,
        ],
        "M" => [
            'literal' => 'million',
            'divisor' => 10**6,
        ],
        "B" => [
            'literal' => 'billion',
            'divisor' => 10**9,
        ],
        "T" => [
            'literal' => 'trillion',
            'divisor' => 10**12,
        ],
    ];

    public static function __callStatic(string $method, array $args)
    {
        if (str_starts_with($method, 'formatFor') 
            && in_array($formula = substr($method, 9, 1), array_keys(static::$formulas))
        ) {
            if (!array_key_exists($formula, static::$formulas)) {
                throw new InvalidArgumentException("Undefined formula for '$formula'");
            }

            $value = $args[0] ?? null;
            $precision = $args[1] ?? 2;
            $useLiteral = $args[2] ?? false;
            $glue = $args[3] ?? '';
            static::validateValue($value);
            $divisor = static::$formulas[$formula]['divisor'];
            $value = round($value / $divisor, $precision);
            if ($useLiteral) {
                $formula = $value < 2 ?
                    static::$formulas[$formula]['literal'] :
                    static::pluralize(static::$formulas[$formula]['literal']);
            }
            return $value . $glue . $formula;
        }
    }

    /**
     * converts a big number string to a number
     * examples: 12K => 12000, 3-millions => 3000000
     *
     * @param  string $value the value
     * @param  string $glue  the glue between the number and the big number name or abbreviation
     * @return int|float
     * @throws InvalidArgumentException
     */
    public static function convertToNumber(string $value, string $glue = '')
    {
        $glue = $glue == '' ? '[.\-\_\s]?' : preg_quote($glue);
        $segments = preg_split('#(?<=[\d.])' . $glue . '(?=[a-z])#i', $value);
        if (count($segments) !== 2) {
            throw new InvalidArgumentException("The value must consist of a number and a big number name or abbreviation (K or thousand(s), M or million(s), B or billion(s), T or trillion(s) ..., ex: 1.2million)");
        }
        foreach (static::$formulas as $abbreviation => $formula) {
            if (in_array(
                $segments[1],
                [
                    $abbreviation,
                    $formula['literal'],
                    static::pluralize($formula['literal'])
                ]
            )
            ) {
                return $segments[0] * $formula['divisor'];
            }
        }
        return null;
    }

    /**
     * adds a new formula
     *
     * @param  string  $abbreviation for example: K, M, B, T
     * @param  string  $literal      (singular) for example: thousand, million, billion, trillion
     * @param  integer $divisor      for example: 1000 for thousand
     * @return void
     * @throws InvalidArgumentException
     */
    public static function addFormula(string $abbreviation, string $literal, int $divisor)
    {
        if (in_array($abbreviation, static::$baseFormulas)) {
            throw new InvalidArgumentException("Cannot override base formula '$abbreviation'");
        }
        static::$formulas[$abbreviation] = ['literal' => $literal, 'divisor' => $divisor];
    }

    public static function getFormulas(): array
    {
        return static::$formulas;
    }

    /**
     * validates a numeric value
     *
     * @param  string|int|float $value
     * @return void
     * @throws InvalidArgumentException
     */
    protected static function validateValue($value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException("The first argument must be a numeric value");
        }
    }

    /**
     * pluralize a string
     *
     * @param  string $value the string to pluralize
     * @return string
     */
    protected static function pluralize(string $value): string
    {
        $vowels = ['a', 'e', 'i', 'o', 'u'];
        if (strlen($value) > 1 
            && in_array($value[-1], ['x', 's']) 
            || in_array($value[-2] . $value[-1], ['ch', 'sh'])
        ) {
            return $value . 'es';
        } elseif (strlen($value) > 1 
            && $value[-1] === 'y' 
            && !in_array($value[-2], $vowels)
        ) {
            return substr($value, 0, -1) . 'ies';
        }
        return $value . 's';
    }
}
