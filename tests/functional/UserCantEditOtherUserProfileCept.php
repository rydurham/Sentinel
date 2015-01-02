<?php 
$I = new FunctionalTester($scenario);

// Prep
$sentry = $I->grabService('sentry');
$user = $sentry->findUserByLogin('user@user.com');
$admin = $sentry->findUserByLogin('admin@admin.com');

// Test
$I->amActingAs('user@user.com');
$I->wantTo('edit another users profile');
$I->amOnPage('/users/' . $admin->id . '/edit');
$I->dontSeeElement('form', ['class' => 'form-horizontal']);
