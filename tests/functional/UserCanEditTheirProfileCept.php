<?php 
$I = new FunctionalTester($scenario);

// Prep
$sentry = $I->grabService('sentry');
$user = $sentry->findUserByLogin('user@user.com');

// Test
$I->amActingAs('user@user.com');
$I->wantTo('edit my own profile');
$I->amOnPage('/users/' . $user->id . '/edit');
$I->seeElement('form', ['class' => 'form-horizontal']);
$I->fillField('first_name', 'Irina');
$I->fillField('last_name', 'Sergeyevna');
$I->click('Submit Changes');
$I->seeRecord('users', [
    'email'      => 'user@user.com',
    'first_name' => 'Irina',
    'last_name'  => 'Sergeyevna'
]);