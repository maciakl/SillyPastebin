<?php
$I = new WebGuy($scenario);
$I->wantTo('Create a new paste');
$I->amOnPage('/');
$I->see("Paste It");
$I->fillField('content', 'This is a triumph...');
$I->click('paste');
$I->see('Your paste is available here');

