<?php require "vendor/autoload.php";

$uri = $_SERVER['REQUEST_URI'];

$pasteCtrl = new SillyPastebin\Controller\PasteController();
$errorCtrl = new SillyPastebin\Controller\ErrorController();

if($uri == '/') {
    $pasteCtrl->showPasteForm();
} elseif($uri == "/paste") {
    try
    {
        if(!empty($_POST["content"]))
        {
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
} elseif($pasteCtrl->isValidPasteURI($uri)) {
    $pasteCtrl->showPasteContent($uri);
} else {
  $errorCtrl->show404();
}
