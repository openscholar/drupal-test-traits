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
     * Get Javascript assert session. Analogous to \Drupal\Tests\BrowserTestBase::assertSession.
     *
     * @param string $name
     *   (optional) Name of the session. Defaults to the active session.
     *
     * @return \Drupal\FunctionalJavascriptTests\JSWebAssert
     *   A Mink assertion object.
     */
    public function assertSession($name = null)
    {
        return new JSWebAssert($this->getSession($name), $this->minkBaseUrl);
    }
}
