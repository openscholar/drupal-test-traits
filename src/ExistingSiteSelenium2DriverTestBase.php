<?php

namespace weitzman\DrupalTestTraits;

use Drupal\FunctionalJavascriptTests\JSWebAssert;

/**
 * You may use this class in any of these ways:
 * - Copy its code into your own base class.
 * - Have your base class extend this class.
 * - Your tests may extend this class directly.
 */
abstract class ExistingSiteSelenium2DriverTestBase extends ExistingSiteBase
{
    use Selenium2DriverTrait;

  /**
   * {@inheritdoc}
   */
    public function assertSession($name = null)
    {
        return new JSWebAssert($this->getSession($name), $this->baseUrl);
    }
}
