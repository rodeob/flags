<?php
namespace tests\unit;

use rbFlags\Flags;

/**
 * Flags class tests
 *
 * @category rbFlags
 * @package  unit
 */
class FlagsTest extends \PHPUnit_Framework_TestCase
{
    const TEST_FLAG1 = 1;
    const TEST_FLAG2 = 2;
    const TEST_FLAG4 = 4;

   /**
     * Tests setting flag in default bag
     *
     * @return void
     */
    public function testSetInDefault()
    {
        $flags = new Flags();
        $flags->setFlags(self::TEST_FLAG1);
        $this->assertAttributeEquals([\rbFlags\Flags::RBFLAGS_DEFAULT_NAME => 1], 'rbFlagsBag', $flags);
        $flags->setFlags(self::TEST_FLAG2);
        $this->assertAttributeEquals([\rbFlags\Flags::RBFLAGS_DEFAULT_NAME => 3], 'rbFlagsBag', $flags);

    }

   /**
     * Tests setting flag in custom bag
     *
     * @return void
     */
    public function testSetInCustom()
    {
        $flags = new Flags();
        $flags->setFlags(self::TEST_FLAG1, 'bag1');
        $this->assertAttributeEquals(['bag1' => 1], 'rbFlagsBag', $flags);
        $flags->setFlags(self::TEST_FLAG2, 'bag2');
        $this->assertAttributeEquals(['bag1' => 1, 'bag2' => 2], 'rbFlagsBag', $flags);
        $flags->setFlags(self::TEST_FLAG4, 'bag1');
        $this->assertAttributeEquals(['bag1' => 5, 'bag2' => 2], 'rbFlagsBag', $flags);
    }

   /**
     * Tests setting multiple flags at once
     *
     * @return void
     */
    public function testSetMultiple()
    {
        $flags = new Flags();
        $flags->setFlags(self::TEST_FLAG1 | self::TEST_FLAG4);
        $this->assertAttributeEquals(['default' => 5], 'rbFlagsBag', $flags);
        $flags->setFlags(self::TEST_FLAG2 | self::TEST_FLAG1, 'bag1');
        $this->assertAttributeEquals(['default' => 5, 'bag1' => 3], 'rbFlagsBag', $flags);
    }

   /**
     * Tests cheching for set flags when no flags set
     *
     * @return void
     */
    public function testIsSetInEmpty()
    {
        $flags = new Flags();

        $this->assertFalse($flags->areFlagsSet(self::TEST_FLAG1));
        $this->assertFalse($flags->areFlagsSet(self::TEST_FLAG2, 'bag1'));
        $this->assertFalse($flags->areFlagsSet(self::TEST_FLAG4, 'bag2'));

        $this->assertFalse($flags->areFlagsSet(self::TEST_FLAG1 | self::TEST_FLAG4));
        $this->assertFalse($flags->areFlagsSet(self::TEST_FLAG2 | self::TEST_FLAG4, 'bag1'));
    }

   /**
     * Tests cheching for set flags in default bag
     *
     * @return void
     */
    public function testIsSetInDefault()
    {
        $flags = new Flags();
        $flags->setFlags(self::TEST_FLAG1 | self::TEST_FLAG4);

        $this->assertTrue($flags->areFlagsSet(self::TEST_FLAG1));
        $this->assertFalse($flags->areFlagsSet(self::TEST_FLAG2));
        $this->assertTrue($flags->areFlagsSet(self::TEST_FLAG4));

        $this->assertTrue($flags->areFlagsSet(self::TEST_FLAG1 | self::TEST_FLAG4));
        $this->assertFalse($flags->areFlagsSet(self::TEST_FLAG2 | self::TEST_FLAG4));
    }

   /**
     * Tests cheching for set flags in custom bag
     *
     * @return void
     */
    public function testIsSetInCustom()
    {
        $flags = new Flags();
        $flags->setFlags(self::TEST_FLAG1 | self::TEST_FLAG4, 'bag1');

        $this->assertTrue($flags->areFlagsSet(self::TEST_FLAG1, 'bag1'));
        $this->assertFalse($flags->areFlagsSet(self::TEST_FLAG2, 'bag1'));
        $this->assertTrue($flags->areFlagsSet(self::TEST_FLAG4, 'bag1'));

        $this->assertTrue($flags->areFlagsSet(self::TEST_FLAG1 | self::TEST_FLAG4, 'bag1'));
        $this->assertFalse($flags->areFlagsSet(self::TEST_FLAG2 | self::TEST_FLAG4, 'bag1'));
    }

   /**
     * Tests areFlagsSet alias isFlagSet
     *
     * @return void
     */
    public function testIsSetAlias()
    {
        $flags = new Flags();
        $flags->setFlags(self::TEST_FLAG1 | self::TEST_FLAG4);

        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG1));
        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG2));
        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG4));

        $flags->setFlags(self::TEST_FLAG2, 'bag1');

        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG2, 'bag1'));
        $this->assertFalse($flags->areFlagsSet(self::TEST_FLAG2 | self::TEST_FLAG4, 'bag1'));
    }

   /**
     * Tests fliping flags
     *
     * @return void
     */
    public function testFlip()
    {
        $flags = new Flags();
        $flags->setFlags(self::TEST_FLAG1);

        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG1));
        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG2));

        $flags->flipFlags(self::TEST_FLAG1)->flipFlags(self::TEST_FLAG2);

        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG1));
        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG2));

        $flags->setFlags(self::TEST_FLAG4, 'bag1');

        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG4, 'bag1'));
        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG2, 'bag2'));

        $flags->flipFlags(self::TEST_FLAG4, 'bag1')->flipFlags(self::TEST_FLAG2, 'bag2');

        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG4, 'bag1'));
        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG2, 'bag2'));
    }

   /**
     * Tests unseting flags
     *
     * @return void
     */
    public function testUnset()
    {
        $flags = new Flags();
        $flags->setFlags(self::TEST_FLAG1);

        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG1));
        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG2));

        $flags->unsetFlags(self::TEST_FLAG1 | self::TEST_FLAG2);

        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG1));
        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG2));

        $flags->setFlags(self::TEST_FLAG4, 'bag1');

        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG4, 'bag1'));
        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG2, 'bag1'));

        $flags->unsetFlags(self::TEST_FLAG1 | self::TEST_FLAG4, 'bag1');

        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG2, 'bag1'));
        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG4, 'bag1'));
    }

   /**
     * Tests chaining
     *
     * @return void
     */
    public function testChaining()
    {
        $flags = new Flags();
        $flags
            ->setFlags(self::TEST_FLAG1 | self::TEST_FLAG2)
            ->unsetFlags(self::TEST_FLAG2)
            ->setFlags(self::TEST_FLAG4, 'bag1')
            ->flipFlags(self::TEST_FLAG2)
            ->flipFlags(self::TEST_FLAG2, 'bag1');
        
        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG1));
        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG2));
        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG4));

        $this->assertFalse($flags->isFlagSet(self::TEST_FLAG1, 'bag1'));
        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG2, 'bag1'));
        $this->assertTrue($flags->isFlagSet(self::TEST_FLAG4, 'bag1'));
    }
}
