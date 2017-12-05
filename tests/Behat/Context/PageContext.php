<?php

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ElementHtmlException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory\DefaultFactory as PageObjectFactory;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class PageContext implements Context
{
    /**
     * @var PageObjectFactory
     */
    private $pageObjectFactory;

    /**
     * @var Page
     */
    private $currentPage;

    /**
     * @param PageObjectFactory $pageObjectFactory
     *
     * @return null|void
     */
    public function setPageObjectFactory(PageObjectFactory $pageObjectFactory)
    {
        $this->pageObjectFactory = $pageObjectFactory;
    }

    /**
     * @Given /^I am on the "(?P<page>[^"]*)" page$/
     *
     * @param string $page
     */
    public function iAmOnThePage($page)
    {
        $this->open($page);
    }

    /**
     * @Then /^the "(?P<elementName>[^"]*)" element should contain "(?P<value>(?:[^"]|\\")*)"$/
     *
     * @param $elementName
     * @param $value
     *
     * @throws \Exception
     */
    public function assertElementContains($elementName, $value)
    {
        $page = $this->getCurrentPage();

        $element = $page->getElement($elementName);

        $actual = preg_replace('/\s+/u', ' ', $value);
        $regex = '/' . preg_quote($element->getHtml(), '/') . '/ui';
        $message = sprintf(
            'The text "%s" was not found anywhere in the text of the %s element.',
            $element->getHtml(),
            $elementName
        );

        if (false == preg_match($regex, $actual)) {
            throw new \Exception($message);
        }
    }

    /**
     * @param string $page
     */
    public function open($page)
    {
        $this->currentPage = $this->getPage($page)->open();
    }

    /**
     * @param string $name
     *
     * @throws \RuntimeException
     *
     * @return Page
     */
    public function getPage($name)
    {
        if (null === $this->pageObjectFactory) {
            throw new \RuntimeException('To create pages you need to pass a factory with setPageObjectFactory()');
        }

        return $this->pageObjectFactory->createPage($name);
    }

    /**
     * @return Page
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @param string $name
     *
     * @throws \RuntimeException
     *
     * @return Element
     */
    public function getElement($name)
    {
        if (null === $this->pageObjectFactory) {
            throw new \RuntimeException('To create elements you need to pass a factory with setPageObjectFactory()');
        }

        return $this->pageObjectFactory->createElement($name);
    }
}
