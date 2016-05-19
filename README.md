# RBFlags

PHP class and trait for manage / set / check flags (bitwise operations). You can organize flags into groups.

## Requirements

- PHP 5.5+

## Installing

Flags is available through Packagist via Composer

```json
{
    "require": {
        "rodeob/flags": "0.*"
    }
}
```

## Usage

This package include class and trait to use it in yours projects.

You can use **rbFlags\Flags** class to extend your class in which you want to use flags.

```php
class MyClass extends rbFlags\Flags {}
```

Or you use the **rbFlags\traits\Flags** trait in your class

```php
class MyClass
{
    use \rbFlags\traits\Flags;
}
```

You can also use **rbFlags\Flags** class as standalone flags class.

```php
$flags = new rbFlags\Flags();
$flags->setFlags(SOME_FLAG);
if ($flags->isFlagSet(SOME_FLAG) {}
```

### Set flags

Method
```php
function setFlags($flags, $bag = FlagsClass::RBFLAGS_DEFAULT_BAG)
```

In class:
```php
$this->setFlags(self::SOME_FLAG);
```

Standalone:
```php
$flags = new rbFlags\Flags();
$flags->setFlags(SOME_FLAG);
```

### Check flags

Method:
```php
function areFlagsSet($flags, $bag = FlagsClass::RBFLAGS_DEFAULT_BAG)
```

and alias:
```php
function isFlagSet($flag, $bag = FlagsClass::RBFLAGS_DEFAULT_BAG)
```

In class:
```php
if ($this->areFlagsSet(self::SOME_FLAG)) {}
```

Standalone:
```php
$flags = new rbFlags\Flags();
if ($flags->areFlagsSet(SOME_FLAG)) {}
```

If you check for multiple flags at once it checks if all flags are set

```php
$this->setFlags(self::SOME_FLAG | self::SOME_OTHER_FLAG1);
if ($this->areFlagsSet(self::SOME_FLAG | self::SOME_OTHER_FLAG1)) {} // true
if ($this->areFlagsSet(self::SOME_FLAG | self::SOME_OTHER_FLAG2)) {} // false
```


### Flip flags

Method:
```php
function flipFlags($flags, $bag = FlagsClass::RBFLAGS_DEFAULT_BAG)
```

In class:
```php
$this->flipFlags(self::SOME_FLAG)
```

Standalone:
```php
$flags = new rbFlags\Flags();
$flags->flipFlags(SOME_FLAG)
```

### Unset flags

Method:
```php
function unsetFlags($flags, $bag = FlagsClass::RBFLAGS_DEFAULT_BAG)
```

In class:
```php
$this->unsetFlags(self::SOME_FLAG)
```

Standalone:
```php
$flags = new rbFlags\Flags();
$flags->unsetFlags(SOME_FLAG)
```

### Multiple flags

In all methods you can, for flags parameter, use mutiple flags at once.

```php
$this->setFlags(self::SOME_FLAG | self::SOME_OTHER_FLAG);
if ($this->areFlagsSet(self::SOME_FLAG | self::SOME_OTHER_FLAG)) {}
$this->flipFlags(self::SOME_FLAG | self::SOME_OTHER_FLAG)
$this->unsetFlags(self::SOME_FLAG | self::SOME_OTHER_FLAG)
```

### Flags bag (groups)

All methods accept also flags bag parameter to organize flags into groups. If you omit this parameter default bag (group) is used.

```php
$this->setFlags(self::SOME_FLAG, 'bagName');
if ($this->areFlagsSet(self::SOME_FLAG, 'bagName')) {}
$this->flipFlags(self::SOME_FLAG, 'bagName')
$this->unsetFlags(self::SOME_FLAG, 'bagName')
```

### Chaining

Methods support chaining.
```php
$this->setFlags(self::SOME_FLAG)
    ->flipFlags(self::SOME_FLAG)
    ->unsetFlags(self::SOME_FLAG);
```
