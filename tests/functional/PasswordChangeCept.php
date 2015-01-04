<?php 
$I = new FunctionalTester($scenario);

// Prep
$sentry = $I->grabService('sentry');
$user = $sentry->findUserByLogin('user@user.com');

// Attempt Password Change
$I->amActingAs('user@user.com');
$I->wantTo('change my password');
$I->amOnPage('/users/' . $user->id . '/edit');
$I->fillField('oldPassword','sentryuser');
$I->fillField('newPassword','sergeyevna');
$I->fillField('newPassword_confirmation','sergeyevna');
$I->click('Change Password', '.btn');
$I->see('Password has been changed.');
$I->logout();

// Test new password
$I->amOnPage('/login');
$I->fillField('email','user@user.com');
$I->fillField('password','sergeyevna');
$I->click('Sign In');
$I->seeCurrentUrlEquals('');
$I->seeInSession('userId', $user->id);

