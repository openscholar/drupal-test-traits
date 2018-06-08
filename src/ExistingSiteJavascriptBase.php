<?php

namespace weitzman\DrupalTestTraits;

use Drupal\FunctionalJavascriptTests\JSWebAssert;

/**
 * You may use this class in any of these ways:
 * - Copy its code into your own base class.
 * - Have your base class extend this class.
 * - Your tests may extend this class directly.
 */
abstract class ExistingSiteJavascriptBase extends ExistingSiteBase
{
    use WebDriverTrait;

    /**
     * Get Javascript assert session. Analogous to \Drupal\Tests\BrowserTestBase::assertSession.
     *
     * @return \Drupal\FunctionalJavascriptTests\JSWebAssert
     *   A Mink assertion object.
     */
    public function assertSession()
    {
        return new JSWebAssert($this->getSession(), $this->minkBaseUrl);
    }
}
