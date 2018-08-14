<?php

namespace weitzman\DrupalTestTraits;

use Behat\Mink\Driver\Selenium2Driver;

trait Selenium2DriverTrait
{

    /**
     * @return \Behat\Mink\Driver\DriverInterface
     */
    protected function getDriverInstance()
    {
        if (!isset($this->driver) && ($driverArgs = getenv('DTT_MINK_DRIVER_ARGS') ?: '["firefox", null, "http://localhost:4444/wd/hub"]')) {
            $driverArgs = json_decode($driverArgs, true);
            $this->driver = new Selenium2Driver(...$driverArgs);
        }
        return $this->driver;
    }
}
