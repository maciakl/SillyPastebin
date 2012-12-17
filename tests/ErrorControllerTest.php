<?php
require_once "vendor/autoload.php";

class ErrorControllerTest extends PHPUnit_Framework_TestCase
{
    protected $err;

    protected function setUp()
    {
        $this->err = new \SillyPastebin\Controller\ErrorController();
    }

    public function testObjectInitialization()
    {
        $this->assertNotNull($this->err);
        $this->assertInstanceOf('\SillyPastebin\Controller\ErrorController', $this->err);
        $this->assertObjectHasAttribute("twig", $this->err);
    }

    public function testShowPasteForm()
    {
        $this->expectOutputRegex("/<h1>404<\/h1>/");
        $this->err->show404();
    }
}
