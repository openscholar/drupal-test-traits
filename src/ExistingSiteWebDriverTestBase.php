<?php

namespace weitzman\DrupalTestTraits;

use Drupal\FunctionalJavascriptTests\JSWebAssert;

/**
 * You may use this class in any of these ways:
 * - Copy its code into your own base class.
 * - Have your base class extend this class.
 * - Your tests may extend this class directly.
 */
abstract class ExistingSiteWebDriverTestBase extends ExistingSiteBase
{
    use WebDriverTrait;

    /**
     * {@inheritdoc}
     */
    public function assertSession($name = null)
    {
        return new JSWebAssert($this->getSession($name), $this->baseUrl);
    }

  /**
   * {@inheritdoc}
   */
    protected function getHtmlOutputHeaders()
    {
      // The webdriver API does not support fetching headers.
        return '';
    }
}
