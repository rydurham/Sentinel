<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('register as a new user');
$I->amOnPage('/register');
$I->fillField('username', 'Tuzenbach');
$I->fillField('email','tuzenbach@aol.com');
$I->fillField('password','irina1899');
$I->fillField('password_confirmation', 'irina1899');
$I->click('Register', '.btn');
$I->see('Your account has been created.');
$I->seeRecord('users', [
    'email' => 'tuzenbach@aol.com',
    'username' => 'Tuzenbach'
]);
