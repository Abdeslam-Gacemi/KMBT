<?php

/**
* @author Abdeslam Gacemi <abdobling@gmail.com>
*/

use Abdeslam\KMBT\KMBT;

require __DIR__ . '/../vendor/autoload.php';

echo '1240: ' . KMBT::formatForK(1240) . '<br>'; // 1.24K
echo '7648: ' . KMBT::formatForK(7648) . '<br>'; // 7.65K
echo '7648: ' . KMBT::formatForK(7648, 1) . '<br>'; // 7.6K
echo '7648: ' . KMBT::formatForK(7648, 1, true) . '<br>'; // 7.6thousands
echo '1240: ' . KMBT::formatForK(1240, 1, true) . '<br>'; // 1.2thousand
echo '1240: ' . KMBT::formatForK(1240, 1, true, ' ') . '<br>'; // 1.2 thousand
echo '1240: ' . KMBT::formatForK(1240, 1, true, '-') . '<br>'; // 1.2-thousand
echo '1240: ' . KMBT::formatForK(1240) . '<br>'; // 1.24K

echo '7648000: ' . KMBT::formatForM(7648000) . '<br>'; // 7.65M
echo '7648000: ' . KMBT::formatForM(7648000, 1) . '<br>'; // 7.6M
echo '7648000: ' . KMBT::formatForM(7648000, 1, true) . '<br>'; // 7.6millions
echo '1240000: ' . KMBT::formatForM(1240000, 1, true) . '<br>'; // 1.2million
echo '1240000: ' . KMBT::formatForM(1240000, 2, true, ' ') . '<br>'; // 1.24 million
echo '1240000: ' . KMBT::formatForM(1240000, 1, true, '-') . '<br>'; // 1.2-million

// ... same for formatForB (billion) & formatForT (trillion)

echo '1.2K: ' . KMBT::convertToNumber('1.2K') . '<br>'; // 1200
echo '1.2 thousand: ' . KMBT::convertToNumber('1.2 thousand') . '<br>'; // 1200
echo '23 thousands: ' . KMBT::convertToNumber('23 thousands') . '<br>'; // 23000
echo '.3 million: ' . KMBT::convertToNumber('.3 million') . '<br>'; // 300000

KMBT::addFormula('H', 'hundred', 10**2);
echo '100: ' . KMBT::formatForH(100) . '<br>'; // 1H
echo '100: ' . KMBT::formatForH(100, 2, true, ' ') . '<br>'; // 1 hundred
echo '320: ' . KMBT::formatForH(320, 2, true, ' ') . '<br>'; // 3,20 hundreds
echo '2.3H: ' . KMBT::convertToNumber('2.3H') . '<br>'; // 230
echo '2.3 hundreds: ' . KMBT::convertToNumber('2.3 hundreds') . '<br>'; // 230
echo '2.3-hundreds: ' . KMBT::convertToNumber('2.3-hundreds') . '<br>'; // 230
echo '2.3 hundreds: ' . KMBT::convertToNumber('2.3hundreds') . '<br>'; // 230

var_dump(KMBT::getFormulas()); // prints the array of formulas

