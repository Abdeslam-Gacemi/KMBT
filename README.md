# KMBT
a PHP big numbers (K => thousand, M => million, B => billion, T => trillion) formatter and converter.

## Usage

```php
<?php

use Abdeslam\KMBT\KMBT;

require __DIR__ . '/../vendor/autoload.php';

echo KMBT::formatForK(1240); // 1.24K
echo KMBT::formatForK(7648); // 7.65K
echo KMBT::formatForK(7648, 1); // 7.6K
echo KMBT::formatForK(7648, 1, true); // 7.6thousands
echo KMBT::formatForK(1240, 1, true); // 1.2thousand
echo KMBT::formatForK(1240, 1, true, ' '); // 1.2 thousand
echo KMBT::formatForK(1240, 1, true, '-'); // 1.2-thousand
echo KMBT::formatForK(1240); // 1.24K

echo KMBT::formatForM(7648000); // 7.65M
echo KMBT::formatForM(7648000, 1); // 7.6M
echo KMBT::formatForM(7648000, 1, true); // 7.6millions
echo KMBT::formatForM(1240000, 1, true); // 1.2million
echo KMBT::formatForM(1240000, 2, true, ' '); // 1.24 million
echo KMBT::formatForM(1240000, 1, true, '-'); // 1.2-million

// ... same for formatForB (billion) & formatForT (trillion)

echo KMBT::convertToNumber('1.2K'); // 1200
echo KMBT::convertToNumber('1.2 thousand'); // 1200
echo KMBT::convertToNumber('23 thousands'); // 23000
echo KMBT::convertToNumber('.3 million'); // 300000

KMBT::addFormula('H', 'hundred', 10**2);
echo KMBT::formatForH(100); // 1H
echo KMBT::formatForH(100, 2, true, ' '); // 1 hundred
echo KMBT::formatForH(320, 2, true, ' '); // 3,20 hundreds
echo KMBT::convertToNumber('2.3H'); // 230
echo KMBT::convertToNumber('2.3 hundreds'); // 230
echo KMBT::convertToNumber('2.3-hundreds'); // 230
echo KMBT::convertToNumber('2.3hundreds'); // 230

var_dump(KMBT::getFormulas()); // prints the array of formulas
```


