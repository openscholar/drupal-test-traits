# Drupal Test Traits

[![Build status](https://gitlab.com/weitzman/drupal-test-traits/badges/master/build.svg)](https://gitlab.com/weitzman/drupal-test-traits/commits/master)
[![project-stage-badge]][project-stage-page]
[![license-badge]][mit]

## Introduction

Traits for testing Drupal sites that have user content (versus unpopulated sites).

[Behat](http://behat.org) is great for facilitating conversations between 
business managers and developers. Those are useful conversations, but many 
organizations simply can't/wont converse via Gherkin. When you are on the hook for 
product quality and not conversations, this is a testing approach for you. 

## Installation

- Install via Composer. `composer require weitzman/drupal-test-traits`.
- [Add one drupal/core patch to your composer.json](https://gitlab.com/weitzman/drupal-test-traits/blob/1.0.0-beta.2/composer.json#L61-65).

## Authoring tests

Pick a test type:
1. **ExistingSiteBrowser**. See [ExampleTest.php](./tests/ExampleTest.php). Start here. These tests can be small unit tests up to larger Functional tests (via [Goutte](http://goutte.readthedocs.io/en/latest/)).
2. **ExistingSiteSelenium2**. See [ExampleSelenium2DriverTest.php](tests/ExampleSelenium2DriverTest.php). These tests make use of any browser which can run in web driver mode(Chrome, FireFox or Edge) via Selenium, so are suited to testing Ajax and similar client side interactions. This browser setup can also be used to run Drupal 8 core JS testing using [nightwatch](https://www.drupal.org/node/2968570). These tests run slower than ExistingSite. To use this test type you need to `composer require 'behat/mink-selenium2-driver'`
3. **ExistingSiteWebDriver**. See [ExampleWebDriverTest.php](tests/ExampleWebDriverTest.php). These tests make use of a headless Chrome browser, so are suited to testing Ajax and similar client side interactions. These tests run slower than ExistingSite. To use this test type you need to `composer require 'dmore/chrome-mink-driver'`

Extend the base class that corresponds to your pick above:
[ExistingSiteBase.php](src/ExistingSiteBase.php), [ExistingSiteWebDriverTestBase.php](src/ExistingSiteWebDriverTestBase.php), or [ExistingSiteSelenium2DriverTestBase.php](src/ExistingSiteSelenium2DriverTestBase.php). 
You may extend it directly from your test class or create a base class for your project that extends one of these.

To choose between [ExistingSiteWebDriverTestBase.php](src/ExistingSiteWebDriverTestBase.php), or [ExistingSiteSelenium2DriverTestBase.php](src/ExistingSiteSelenium2DriverTestBase.php) for JS (Ajax and similar client side interactions) testing read [testing Drupal with WebDriver browser mode vs Headless browser mode](https://www.previousnext.com.au/blog/testing-drupal-webdriver-browser-mode-vs-headless-browser-mode).
  
## Running tests

- You must specify the URL to your site as an environment variable: `DTT_BASE_URL=http://example.com`. For ExistingSiteJavascript also specify `DTT_MINK_DRIVER_ARGS=["firefox", null, "http://selenium:9222/wd/hub"]` or `DTT_API_URL=http://localhost:9222`. Here are three ways to do that:
    - Specify in a phpunit.xml. [See example](docs/phpunit.xml).
    - Enter that line into a .env file. These files are supported by [drupal-project](https://github.com/drupal-composer/drupal-project/blob/8.x/.env.example) and [Docker](https://docs.docker.com/compose/env-file/). 
    - Specify environment variables at runtime: `DTT_BASE_URL=http://127.0.0.1:8888;DTT_API_URL=http://localhost:9222 vendor/bin/phpunit ...`
- Add --bootstrap option like so: `--bootstrap=vendor/weitzman/drupal-test-traits/src/bootstrap.php `
- Depending on your setup, you may wish to run phpunit as the web server user `su -s /bin/bash www-data -c "vendor/bin/phpunit ..."`

## Debugging tests

- For ExistingSite, all HTML requests can be logged: 
    - Define the environment variable BROWSERTEST_OUTPUT_DIRECTORY. See .env.example or [docs/phpunit.xml](docs/phpunit.xml) for guidance.
    - Add `--printer '\\Drupal\\Tests\\Listeners\\HtmlOutputPrinter'` to the phpunit call. Alternatively specify this in a [phpunit.xml](docs/phpunit.xml).  
- For ExistingSiteSelenium2 or ExistingSiteWebDriver , use `file_put_contents('public://screenshot.jpg', $this->getSession()->getScreenshot());` to take screenshot of the current page.
- To check the current HTML of the page use `file_put_contents('public://' . drupal_basename($session->getCurrentUrl()) . '.html', $this->getCurrentPageContent());`

### Bootstrap options
To allow use of `ExistingSite` and `ExistingSiteJavascript` autoloading to be work alongside core's (`Unit`, `Kernel`, etc),
this project's [`bootstrap.php`](src/bootstrap.php) should be used:

```bash
vendor/bin/phpunit --bootstrap=vendor/weitzman/drupal-test-traits/src/bootstrap.php
```
Alternatively, specify this in a custom `phpunit.xml` file ([See example](docs/phpunit.xml)).

If you have your own `bootstrap.php` file, refer to [this project's version](src/bootstrap.php), and add the
`ExistingSite` and `ExistingSiteJavascript` namespaces logic to your own.

## Available traits

- **DrupalTrait**  
  Bootstraps Drupal so that its API's are available. Also offers an entity cleanup
  API so databases are kept relatively free of testing content.

- **GoutteTrait**  
  Makes Goutte available for browser control, and offers a few helper methods.

- **Selenium2DriverTrait**   
  Make [Selenium2Driver]([Selenium2Driver](https://github.com/minkphp/MinkSelenium2Driver)) available for browser control with Selenium. Suitable for functional javascript testing.

- **WebDriverTrait**   
  Make [ChromeDriver]([ChromeDriver](https://gitlab.com/DMore/chrome-mink-driver/)) available for browser control without the overhead of Selenium. Suitable for functional javascript testing.

- **NodeCreationTrait**  
  Create nodes that are automatically deleted at end of test method.
  
- **TaxonomyCreationTrait**
  Create terms and vocabularies that are deleted at the end of the test method.
  
- **UserCreationTrait**
  Create users and roles that are deleted at the end of the test method.
  
- **MailCollectionTrait**  
  Enables the collection of emails during tests. Assertions can be made against
  contents of these as core's `AssertMailTrait` is included.  
  
## Contributing

Contributions to the this project are welcome! Please file issues and pull requests.
All pull requests are automatically tested via [GitLab CI](https://gitlab.com/weitzman/drupal-test-traits/pipelines).

See docker-compose.yml for a handy development environment.

See the [#testing channel on Drupal Slack](https://drupal.slack.com/messages/C223PR743) for discussion about this project. 

## Colophon

- **Author**: Created by [Moshe Weitzman](http://weitzman.github.io).
- **Maintainers**: Maintained by [Moshe Weitzman](http://weitzman.github.io), [Jibran Ijaz (jibran)](https://www.drupal.org/u/jibran), [Rob Bayliss](https://github.com/rbayliss), and the Community.
- **License**: Licensed under the [MIT license][mit]

[mit]: ./LICENSE.md
[license-badge]: https://img.shields.io/badge/License-MIT-blue.svg
[project-stage-badge]: http://img.shields.io/badge/Project%20Stage-Development-yellowgreen.svg
[project-stage-page]: http://bl.ocks.org/potherca/raw/a2ae67caa3863a299ba0/
