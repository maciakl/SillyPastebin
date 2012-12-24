<?php
require_once "vendor/autoload.php";

class PasteControllerTest extends PHPUnit_Framework_TestCase
{
    protected $ctrl;

    protected function setUp()
    {
        $this->ctrl = new \SillyPastebin\Controller\PasteController();
    }

    public static function tearDownAfterClass()
    {
       // if(file_exists("/tmp/red.db"))
       //     unlink("/tmp/red.db");
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

    public function testAddNewPasteWithValidStringAndPHPLanguage()
    {
        $content = "some text to be pasted";
        $language = "php";
        $temp = $this->ctrl->addNewPaste($content, $language);
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

    public function testShowThankYouWithValidContent()
    {
        $content = "some content";
        $temp = $this->ctrl->addNewPaste($content);
        
        $this->expectOutputRegex("/Your paste is available here: <a href='\/$temp'>#$temp<\/a>/");     
        $this->ctrl->showThankYou($temp);
    }
    

    public function testShowThankYouWithValidContentAndPHPLanguage()
    {
        $content = "some content";
        $language = "php";
        $temp = $this->ctrl->addNewPaste($content, $language);
        
        $this->expectOutputRegex("/<pre class=\"$language\"/");     
        $this->ctrl->showPasteContent("/".$temp);
    }

    public function testShowThankYouWithValidContentAndNonexistentLanguage()
    {
        $content = "saxophone";
        $language = "gandalfthegrayandalsohobbit";
        $temp = $this->ctrl->addNewPaste($content, $language);
        
        $this->expectOutputRegex("/<pre class=\"$language\"/");     
        $this->ctrl->showPasteContent("/".$temp);
    }
}
