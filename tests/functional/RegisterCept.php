<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('register as a new user');
$I->amOnPage('/register');
$I->fillField('username', 'rydurham');
$I->fillField('email','rydurham@gmail.com');
$I->fillField('password','Fool~256');
$I->fillField('password_confirmation', 'Fool~256');
$I->click('Register', '.btn');
$I->see('You have arrived.');
$I->seeRecord('users', [
    'email' => 'rydurham@gmail.com',
    'username' => 'rydurham'
]);
