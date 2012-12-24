<?php 

// dependencies and autoloding are handled by Composer
// see composer.json for package list and autoload rules
require "vendor/autoload.php";

// using Front Controller pattern - relative URI is used for routing
$uri = $_SERVER['REQUEST_URI'];

// classes are auto-loaded as per composer.json
$pasteCtrl = new SillyPastebin\Controller\PasteController();
$errorCtrl = new SillyPastebin\Controller\ErrorController();


// FRONT CONTROLLER
// see .htaccess for Apache rewrite rules that are necessary to make this work
if($uri == '/') 
{
    $pasteCtrl->showPasteForm();
} 
elseif($uri == "/paste") 
{
    try
    {
        if(!empty($_POST["content"]))
        {
            // shows thank-you page and a link or an error
            $pasteID = $pasteCtrl->addNewPaste($_POST["content"], $_POST["language"]);
            $pasteCtrl->showThankYou($pasteID);
        }
        else
            $errorCtrl->showGenericError("Paste content cannot be empty.");
    }
    catch (InvalidArgumentException $e)
    {
        $errorCtrl->showGenericError($e->getMessage());
    }
} 
elseif($pasteCtrl->isValidPasteURI($uri)) 
{
    $pasteCtrl->showPasteContent($uri);
} 
else 
{
  $errorCtrl->show404();
}
