<?php 
$I = new FunctionalTester($scenario);

// Prep
$sentry = $I->grabService('sentry');
$user = $sentry->findUserByLogin('user@user.com');
$admin = $sentry->findUserByLogin('admin@admin.com');

// Turn on filters for the testing environment
$router = $I->grabService('router');
$router->enableFilters();

// Test
$I->amActingAs('user@user.com');
$I->wantTo('edit another users profile');
$I->amOnPage('/users/' . $admin->hash . '/edit');
$I->dontSeeElement('form', ['class' => 'form-horizontal']);
