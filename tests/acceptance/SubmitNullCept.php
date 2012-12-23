<?php
$I = new WebGuy($scenario);
$I->wantTo('Submit null value');
$I->amOnPage('/');
$I->submitForm('#paste', array('content' => null));
$I->see('Paste content cannot be empty');
