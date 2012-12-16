<?php

require "vendor/autoload.php";
require "PasteController.php";

//use RedBean_Facade as R;

$uri = $_SERVER['REQUEST_URI'];

$pasteCtrl = new PasteController();

if($uri == '/') {
    $pasteCtrl->showPasteForm();
} elseif($uri == "/paste") {
    $pasteCtrl->addNewPaste();
} elseif($pasteCtrl->isValidPasteURI($uri)) {
    $pasteCtrl->showPasteContents($uri);
} else {
  $paste->show404();
}
