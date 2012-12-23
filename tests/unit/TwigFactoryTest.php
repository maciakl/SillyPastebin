<?php
require_once "vendor/autoload.php";

class TwigFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $test;

    protected function setUp()
    {
    }

    public function testGetTwig()
    {
        $test = SillyPastebin\Helper\TwigFactory::getTwig();
        $this->assertNotNull($test);
        $this->assertInstanceOf('\Twig_Environment', $test);

    }
}
