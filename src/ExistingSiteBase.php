<?php

namespace weitzman\DrupalTestTraits;

use Drupal\KernelTests\AssertLegacyTrait;
use Drupal\Tests\RandomGeneratorTrait;
use Drupal\Tests\UiHelperTrait;
use PHPUnit\Framework\TestCase;
use weitzman\DrupalTestTraits\Entity\NodeCreationTrait;
use weitzman\DrupalTestTraits\Entity\TaxonomyCreationTrait;
use weitzman\DrupalTestTraits\Entity\UserCreationTrait;

/**
 * You may use this class in any of these ways:
 * - Copy its code into your own base class.
 * - Have your base class extend this class.
 * - Your tests may extend this class directly.
 */
abstract class ExistingSiteBase extends TestCase
{

    use DrupalTrait;
    use GoutteTrait;
    use NodeCreationTrait;
    use UserCreationTrait;
    use TaxonomyCreationTrait;
    use UiHelperTrait;

    // The entity creation traits need this.
    use RandomGeneratorTrait;

    // Core is still using this in role creation, so it must be included here when
    // using the UserCreationTrait.
    use AssertLegacyTrait;

    /**
     * The database prefix of this test run.
     *
     * @var string
     */
    protected $databasePrefix;

    /**
     * The base URL.
     *
     * @var string
     */
    protected $baseUrl;

    public function setUp()
    {
        parent::setUp();
        $this->setupMinkSession();
        $this->setupDrupal();

        // Ensure that the test is not marked as risky because of no assertions. In
        // PHPUnit 6 tests that only make assertions using $this->assertSession()
        // can be marked as risky.
        $this->addToAssertionCount(1);
    }

  /**
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
    public function tearDown()
    {
        parent::tearDown();
        $this->tearDownDrupal();
        $this->tearDownMinkSession();
    }
}
