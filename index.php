<?php require "vendor/autoload.php";

$uri = $_SERVER['REQUEST_URI'];

$pasteCtrl = new SillyPastebin\Controller\PasteController();
$errorCtrl = new SillyPastebin\Controller\ErrorController();

if($uri == '/') {
    $pasteCtrl->showPasteForm();
} elseif($uri == "/paste") {
    $pasteCtrl->addNewPaste($_POST["content"]);
} elseif($pasteCtrl->isValidPasteURI($uri)) {
    $pasteCtrl->showPasteContent($uri);
} else {
  $errorCtrl->show404();
}
