<?php
/**
 * Flags trait.
 *
 * @category rbFlags
 * @package  flags
 */
namespace rbFlags\traits;

use rbFlags\Flags as FlagsClass;

trait Flags
{
    /**
     * Holds all the flags
     *
     * @var array
     */
    private $rbFlagsBag = [];

    /**
     * Set the flags in specific flags bag
     *
     * @param  integer $flags
     * @param  string $bag
     * @return self
     */
    function setFlags($flags, $bag = FlagsClass::RBFLAGS_DEFAULT_BAG)
    {
        $this->rbFlagsBag[$bag] = isset($this->rbFlagsBag[$bag]) ? $this->rbFlagsBag[$bag] | $flags : $flags;
        return $this;
    }

    /**
     * Checks if all flags are set in specific flags bag
     *
     * @param  integer $flags
     * @param  string $bag
     * @return boolean
     */
    function areFlagsSet($flags, $bag = FlagsClass::RBFLAGS_DEFAULT_BAG)
    {
        if (!isset($this->rbFlagsBag[$bag])) {
            return false;
        }
        return ($this->rbFlagsBag[$bag] & $flags) === $flags;
    }

    /**
     * Checks if flag is set in specific flags bag
     *
     * @param  integer $flag
     * @param  string $bag
     * @return boolean
     */
    function isFlagSet($flag, $bag = FlagsClass::RBFLAGS_DEFAULT_BAG)
    {
        return $this->areFlagsSet($flag, $bag);
    }

    function flipFlags($flags, $bag = FlagsClass::RBFLAGS_DEFAULT_BAG)
    {
        $this->rbFlagsBag[$bag] = isset($this->rbFlagsBag[$bag])
            ? $this->rbFlagsBag[$bag] ^ $flags
            : $flags;
        return $this;
    }

    /**
     * Unset flags in specific flags bag
     *
     * @param  integer $flags
     * @param  string $bag
     * @return self
     */
    function unsetFlags($flags, $bag = FlagsClass::RBFLAGS_DEFAULT_BAG)
    {
        if (isset($this->rbFlagsBag[$bag])) {
            $this->rbFlagsBag[$bag] = $this->rbFlagsBag[$bag] & (~$flags);
        }
        return $this;
    }
}
