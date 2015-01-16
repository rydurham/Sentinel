<?php 
$I = new FunctionalTester($scenario);

// Create the reset code
$I->wantTo('reset my forgotten password');
$I->amOnPage('/forgot');
$I->fillField('email','user@user.com');
$I->click('Send Instructions', '.btn');
$I->see('Check your email for instructions.');

// Prep for reset
$sentry = $I->grabService('sentry');
$user = $sentry->findUserByLogin('user@user.com');
$code = $user->getResetPasswordCode();

// Attempt reset
$I->amOnPage(route('sentinel.reset.form', ['hash' => $user->hash, 'code' => $code]));
$I->fillField('password','sergeyevna');
$I->fillField('password_confirmation','sergeyevna');
$I->click('Reset Password', '.btn');
$I->see('Password has been changed.');

// Test new password
$I->amOnPage('/login');
$I->fillField('email','user@user.com');
$I->fillField('password','sergeyevna');
$I->click('Sign In');
$I->seeCurrentUrlEquals('');
$I->seeInSession('userId', $user->id);

