<?php
$I = new WebGuy($scenario);
$I->wantTo('Submit an empty string');
$I->amOnPage('/');
$I->click('paste');
$I->see('Paste content cannot be empty');
