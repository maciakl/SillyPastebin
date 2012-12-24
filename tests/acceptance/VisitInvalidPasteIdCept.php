<?php
$I = new WebGuy($scenario);
$I->wantTo('Visit an invalid paste id like /foo');
$I->amOnPage('/foo');
$I->see("404");
$I->see("Page not found");
