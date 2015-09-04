# JimmyOak Utilities

[![Build Status](https://travis-ci.org/jimmyoak/utilities.svg?branch=master)](https://travis-ci.org/jimmyoak/utilities)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jimmyoak/utilities/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jimmyoak/utilities/?branch=master)

- [Installation](#installation)
- [Features](#features)
- [Examples](#examples)
 - [Collections](#collections)
  - [Collection](#collection)
  - [TypedCollection](#typedcollection)
  - [UniquedCollection](#uniquedcollection)
  - [UniquedTypedCollection](#uniquedtypedcollection)
 - [DataType](#datatype)
  - [Enum](#enum)
  - [SimpleValueObject](#simplevalueobject)
 - [ArrayUtils](#arrayutils)
  - [Flatten](#flatten)
  - [ToXmlString and ToXml](#toxmlstring-and-toxml)
 - [ObjectUtils](#objectutils)
  - [ToArray](#toarray)
  - [ToXmlString and ToXml](#toxmlstring-and-toxml)
 - [StringUtils](#stringutils)
  - [BeginsWith](#beginswith)
  - [EndsWith](#endswith)
  - [RemoveAccents](#removeaccents)
  - [RemoveExtraSpaces](#removeextraspaces)
  - [IsUrl and IsEmail](#isurl-and-isemail)
 - [FileUtils](#fileutils)
  - [ExtensionIs](#extensionis)
  - [ScanDir](#ScanDir)
- [Quality](#quality)
- [Contribute](#contribute)
- [Authors](#authors)
- [License](#license)


## Installation

Use [Composer](https://getcomposer.org) to install the package:

```bash
$ composer require jimmyoak/utilities
```

## Features

- Collection utilities (Unique and/or Typed Collections) 
- Enum base class
- SimpleValueObject base class
- Array utilities
- File utilities
- String utilities

## Examples

### Collections

#### Collection

```php
$collection = new \JimmyOak\Collection\Collection();
$collection[] = 'Foo';
$collection[] = 'Bar';

foreach ($collection as $value) {
    echo $value . ' ';
}

//prints: Foo Bar
```

#### TypedCollection

```php
$collection = new \JimmyOak\Collection\TypedCollection(\DateTime::class);
$collection[] = new \DateTime();
$collection[] = new \DateInterval('P1D'); //Throws \JimmyOak\Exception\Collection\NotValidObjectTypeException
```

#### UniquedCollection

You can fill the collection with object, scalars...
```php
$collection = new \JimmyOak\Collection\UniquedCollection();
$collection[] = 'Foo';
$collection[] = 'Foo';
$collection[] = 'Bar';

foreach ($collection as $value) {
    echo $value . ' ';
}

//prints: Foo Bar
```

#### UniquedTypedCollection

You can fill the collection with object, scalars...
```php
$collection = new \JimmyOak\Collection\UniquedTypedCollection(\DateTime::class);
$aDateTime = new \DateTime('1992-10-07');
$collection[] = $aDateTime;
$collection[] = $aDateTime;
try {
    $collection[] = new \DateInterval('P1D'); //throws \JimmyOak\Exception\Collection\NotValidObjectTypeException
} catch (\JimmyOak\Exception\Collection\NotValidObjectTypeException $e) {
    //Do nothing ^^'
}

foreach ($collection as $value) {
    echo $value->format('Y-m-d') . ' ';
}

//prints: 1992-10-07
```

Of course you can hipervitaminate these classes:

```php
class DateTimeCollection extends \JimmyOak\Collection\UniquedTypedCollection
{
    public function __construct() {
        $this->setObjectType(\DateTime::class);
    }
    
    public function asStrings()
    {
        $dates = [];
        foreach ($this as $value) {
            $dates[] = $value->format('Y-m-d');
        }
        
        return $dates;
    }
}

$dateTimeCollection = new \DateTimeCollection();
$aDateTime = new \DateTime('1992-10-07');
$dateTimeCollection[] = $aDateTime;
$dateTimeCollection[] = $aDateTime;
$dateTimeCollection[] = new \DateTime('1992-09-08');

foreach ($dateTimeCollection->asStrings() as $dateTimeString) {
    echo $dateTimeString . ' - ';
}

// prints: 1992-10-07 - 1992-09-08 - 
```

### DataType

#### Enum

```php
class FuelType extends \JimmyOak\DataType\Enum
{
    const GASOLINE = 'gasoline';
    const DIESEL = 'diesel';
    const KEROSENE = 'kerosene';
}

echo 'Available fuels: ' . PHP_EOL;
foreach (FuelType::getConstList() as $constName => $value) {
    echo $constName . ' => ' . $value . PHP_EOL;
}

echo PHP_EOL;
//prints:
// Available fuels:
// GASOLINE => gasoline
// DIESEL => diesel
// KEROSENE => kerosene

$gasoline = new FuelType(FuelType::GASOLINE);
echo $gasoline->value() . PHP_EOL; //prints: 'gasoline'
echo (string) $gasoline . PHP_EOL; //prints: 'gasoline'

$nonExistentFuelType = new FuelType('grass'); //throws \InvalidArgumentException
```

### SimpleValueObject

```php
class Amount extends \JimmyOak\DataType\SimpleValueObject
{
    public function add(Amount $amount) {
        return $this->mutate($this->value() + $amount->value());
    }
}

$amount = new \Amount(500);
echo (string) $amount . PHP_EOL; //prints: 500
echo $amount->value() . PHP_EOL; //prints: 500

$anotherAmount = new \Amount(700);
echo ($amount->equals($anotherAmount) ? 'EQUAL' : 'NOT EQUAL') . PHP_EOL; //prints: NOT EQUAL

$newAmount = $amount->add(new Amount(200));
echo $amount->value() . PHP_EOL; //prints: 500
echo $newAmount->value() . PHP_EOL; //prints: 700

echo ($anotherAmount->equals($newAmount) ? 'EQUAL' : 'NOT EQUAL') . PHP_EOL; //prints: EQUAL
```

## Utility

### ArrayUtils

#### Flatten

```php
$array = [
    'FOO',
    [ 'BAR' ],
    'CHILDREN' => [
        'FOO2' => 'FOOBAR',
        'BAR2' => 'FOOBAR2',
        [
            'FOO2' => 'FOOBAR3'
        ]
    ]
];

$notPreservedKeys = \JimmyOak\Utility\ArrayUtils::instance()->flatten($array, \JimmyOak\Utility\ArrayUtils::NO_PRESERVE_KEYS);
// Overrides existing keys (overrides keys 0 and FOO2 existing in children)
$preservedKeys = \JimmyOak\Utility\ArrayUtils::instance()->flatten($array, \JimmyOak\Utility\ArrayUtils::PRESERVE_KEYS);
// Overrides only ASSOCIATIVE KEYS
$preservedAssociativeKeys = \JimmyOak\Utility\ArrayUtils::instance()->flatten($array, \JimmyOak\Utility\ArrayUtils::PRESERVE_ASSOCIATIVE_KEYS);

var_export($notPreservedKeys);
echo PHP_EOL . PHP_EOL;
var_export($preservedKeys);
echo PHP_EOL . PHP_EOL;
var_export($preservedAssociativeKeys);

// prints:
// array (
//   0 => 'FOO',
//   1 => 'BAR',
//   2 => 'FOOBAR',
//   3 => 'FOOBAR2',
//   4 => 'FOOBAR3',
// )
// 
// array (
//   0 => 'BAR',
//   'FOO2' => 'FOOBAR3',
//   'BAR2' => 'FOOBAR2',
// )
// 
// array (
//   0 => 'FOO',
//   1 => 'BAR',
//   'FOO2' => 'FOOBAR3',
//   'BAR2' => 'FOOBAR2',
// )
```

#### ToXmlString and ToXml

```php
$array = [
    'details' => [
        'media' => [
            'image' => [
                'anImage.png',
                'anotherImage.png',
            ],
            'video' => 'aVideo.mp4',
            'audio' => [],
        ]
    ]
];

$xml = \JimmyOak\Utility\ArrayUtils::instance()->toXmlString($array);
echo $xml . PHP_EOL . PHP_EOL;

// prints: <?xml version="1.0" encoding="UTF-8"? ><details><media><image>anImage.png</image><image>anotherImage.png</image><video>aVideo.mp4</video><audio/></media></details>

// Converts array into SimpleXmlElement
$xml = \JimmyOak\Utility\ArrayUtils::instance()->toXml($array);
var_dump($xml);

// prints:
// class SimpleXMLElement#3 (1) {
//     public $media =>
//     class SimpleXMLElement#4 (3) {
//         public $image =>
//         array(2) {
//             [0] =>
//             string(11) "anImage.png"
//             [1] =>
//             string(16) "anotherImage.png"
//         }
//         public $video =>
//         string(10) "aVideo.mp4"
//         public $audio =>
//         class SimpleXMLElement#5 (0) {
//         }
//     }
// }
```

### ObjectUtils

#### ToArray

```php
class Foo
{
    public $public = 'public';
    protected $protected = 'protected';
    private $private = 'private';
    private $anObject;

    /**
     * Foo constructor.
     *
     * @param $anObject
     */
    public function __construct($anObject)
    {
        $this->anObject = $anObject;
    }
}

class Bar
{
    private $value = 'value';
}

$foo = new Foo(new Bar());

//Shallow
$arrayed = \JimmyOak\Utility\ObjectUtils::instance()->toArray($foo, \JimmyOak\Utility\ObjectUtils::SHALLOW);
var_export($arrayed);
// prints:
//array (
//    'public' => 'public',
//)

echo PHP_EOL . PHP_EOL;

//Deep
$arrayed = \JimmyOak\Utility\ObjectUtils::instance()->toArray($foo, \JimmyOak\Utility\ObjectUtils::DEEP);
var_export($arrayed);
// prints:
//array (
//    'public' => 'public',
//    'protected' => 'protected',
//    'private' => 'private',
//    'anObject' =>
//        array (
//            'value' => 'value',
//        ),
//)
```

#### ToXmlString and ToXml

Note: ToXml would do the same but returns a SimpleXml object

```php
class Foo
{
    public $public = 'public';
    protected $protected = 'protected';
    private $private = 'private';
    private $anObject;

    /**
     * Foo constructor.
     *
     * @param $anObject
     */
    public function __construct($anObject)
    {
        $this->anObject = $anObject;
    }
}

class Bar
{
    private $value = 'value';
}

$foo = new Foo(new Bar());

$xml = \JimmyOak\Utility\ObjectUtils::instance()->toXmlString($foo, \JimmyOak\Utility\ObjectUtils::SHALLOW);
echo $xml . PHP_EOL;
// prints: <?xml version="1.0" encoding="UTF-8"? ><public>public</public>

$xml = \JimmyOak\Utility\ObjectUtils::instance()->toXmlString($foo, \JimmyOak\Utility\ObjectUtils::DEEP);
echo $xml . PHP_EOL;
// prints: <?xml version="1.0" encoding="UTF-8"? ><public>public</public><protected>protected</protected><private>private</private><anObject><value>value</value></anObject>
```

### StringUtils

#### BeginsWith
```php
echo (\JimmyOak\Utility\StringUtils::instance()->beginsWith('Foo', 'fo') ? 'true' : 'false') . PHP_EOL;
//prints: false
echo (\JimmyOak\Utility\StringUtils::instance()->beginsWith('Foo', 'fo', \JimmyOak\Utility\StringUtils::CASE_INSENSITIVE) ? 'true' : 'false') . PHP_EOL;
//returns: true

echo (\JimmyOak\Utility\StringUtils::instance()->beginsWith('Fóo', 'Fo') ? 'true' : 'false') . PHP_EOL;
//prints: false
echo (\JimmyOak\Utility\StringUtils::instance()->beginsWith('Fóo', 'Fo', \JimmyOak\Utility\StringUtils::ACCENT_INSENSITIVE) ? 'true' : 'false') . PHP_EOL;
//returns: true

echo (\JimmyOak\Utility\StringUtils::instance()->beginsWith(
        'Fóo',
        'fo',
        \JimmyOak\Utility\StringUtils::ACCENT_INSENSITIVE | \JimmyOak\Utility\StringUtils::CASE_INSENSITIVE
    ) ? 'true' : 'false') . PHP_EOL;
//returns: true
```

#### EndsWith

Same behaviour as beginsWith but with ending needle.

#### RemoveAccents

```php
echo \JimmyOak\Utility\StringUtils::instance()->removeAccents('Fóôñ');
// prints: Foon
```

#### RemoveExtraSpaces

```php
echo \JimmyOak\Utility\StringUtils::instance()->removeExtraSpaces('  Foo    Bar     ');
// prints: Foo Bar
```

#### IsUrl and IsEmail

```php
echo (\JimmyOak\Utility\StringUtils::instance()->isUrl('http://github.com/jimmyoak') ? 'true' : 'false') . PHP_EOL;
// prints: true

echo (\JimmyOak\Utility\StringUtils::instance()->isUrl('github.com/jimmyoak') ? 'true' : 'false') . PHP_EOL;
// prints: false

echo (\JimmyOak\Utility\StringUtils::instance()->isEmail('adrian.robles.maiz@gmail.com') ? 'true' : 'false') . PHP_EOL;
// prints: true

echo (\JimmyOak\Utility\StringUtils::instance()->isEmail('adrian.robles.maiz') ? 'true' : 'false') . PHP_EOL;
// prints: false
```

### FileUtils

#### ExtensionIs

```php
echo (\JimmyOak\Utility\FileUtils::instance()->extensionIs('foo.php', 'php') ? 'true' : 'false') . PHP_EOL;
// prints: true

echo (\JimmyOak\Utility\FileUtils::instance()->extensionIs('foo.php', 'bar') ? 'true' : 'false') . PHP_EOL;
// prints: false
```

#### ScanDir

See FileUtilsTest better :P

----


## Quality

To run the PHPUnit tests at the command line, go to the tests directory and issue `phpunit`.

This library attempts to comply with [PSR-2](http://www.php-fig.org/psr/psr-2/) and [PSR-4](http://www.php-fig.org/psr/psr-4/).

If you notice compliance oversights, please send a patch via pull request.

## Contribute

Contributions to the package are always welcome!

* Report any bugs or issues you find on the [issue tracker](https://github.com/jimmyoak/utilities/issues/new).
* You can grab the source code at the package's [Git repository](https://github.com/jimmyoak/utilities).

## Authors

* [Adrián Robles Maiz (a.k.a Jimmy K. Oak)] (http://github.com/jimmyoak)

## License
The code base is licensed under the MIT license.
