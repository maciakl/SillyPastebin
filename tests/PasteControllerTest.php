<?php
require_once "vendor/autoload.php";

class PasteControllerTest extends PHPUnit_Framework_TestCase
{
    protected $ctrl;

    protected function setUp()
    {
        $this->ctrl = new \SillyPastebin\Controller\PasteController();
    }

    public function testObjectInitialization()
    {
        $this->assertNotNull($this->ctrl);
        $this->assertInstanceOf('\SillyPastebin\Controller\PasteController', $this->ctrl);
        $this->assertObjectHasAttribute("twig", $this->ctrl);
    }

    public function testShowPasteForm()
    {
        $this->expectOutputRegex("/<title>Paste It<\/title>/");
        $this->ctrl->showPasteForm();
    }

    public function testIsValidPasteURI()
    {
        $temp = $this->ctrl->isValidPasteURI("/234");
        $this->AssertTrue($temp);
        
        $temp = $this->ctrl->isValidPasteURI("/foo");
        $this->AssertFalse($temp);

        $temp = $this->ctrl->isValidPasteURI("/foo/434");
        $this->AssertFalse($temp);

        $temp = $this->ctrl->isValidPasteURI("234");
        $this->AssertFalse($temp);

        $temp = $this->ctrl->isValidPasteURI("/234/343/34");
        $this->AssertFalse($temp);
        
        $temp = $this->ctrl->isValidPasteURI("/-234");
        $this->AssertFalse($temp);
    }

    public function testAddNewPasteWithValidString()
    {
        $content = "some text to be pasted";
        $temp = $this->ctrl->addNewPaste($content);
        $this->assertNotNull($temp);
        $this->assertInternalType('integer', $temp);
    }

    /**
     * @expectedException        InvalidArgumentException
     */
    public function testAddNewPasteWithNull()
    {
        $content = null;
        $temp = $this->ctrl->addNewPaste($content);
    }

    public function testShowPasteContentWith1()
    {
        $this->expectOutputRegex("/some text to be pasted/");
        $this->ctrl->showPasteContent("/1");
    }

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Invalid paste ID
     */
    public function testShowPasteContentWithInvalidUri()
    {
        $this->ctrl->showPasteContent("foo");
    }

    public function testShowPasteContentWith9999()
    {
        $this->expectOutputRegex("/No such paste/");
        $this->ctrl->showPasteContent("/9999");
    }       
}
