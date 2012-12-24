<?php
$code = '$foo = new Bar();';
$I = new WebGuy($scenario);
$I->wantTo('Create a new paste in PHP');
$I->amOnPage('/');
$I->see("Paste It");
$I->submitForm('#paste', array('content' => $code, 'language' => 'php'));
$I->see("Your paste is available here");
$I->click("#");
$I->see($code, '//body/code/pre');

