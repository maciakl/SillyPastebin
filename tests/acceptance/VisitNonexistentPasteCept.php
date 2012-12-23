<?php
$I = new WebGuy($scenario);
$I->wantTo('Visit paste #99999');
$I->amOnPage('/99999');
$I->see("No such paste");
