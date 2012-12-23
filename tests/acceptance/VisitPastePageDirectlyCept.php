<?php
$I = new WebGuy($scenario);
$I->wantTo('Visit /paste directly with no input');
$I->amOnPage('/paste');
$I->see("Paste content cannot be empty");
