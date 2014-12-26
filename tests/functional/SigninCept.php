<?php 
$I = new FunctionalTester($scenario);

// Preparation
$sentry = $I->grabService('sentry');
$user = $sentry->findUserByLogin('user@user.com');

// Test
$I->wantTo('log in as regular user');
$I->amOnPage('/login');
$I->fillField('email','user@user.com');
$I->fillField('password','sentryuser');
$I->click('Sign In');
$I->see('You have arrived.');
$I->seeInSession('userId', $user->id);
