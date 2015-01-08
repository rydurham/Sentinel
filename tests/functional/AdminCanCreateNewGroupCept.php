<?php 
$I = new FunctionalTester($scenario);

// Prep
$sentry = $I->grabService('sentry');
$user = $sentry->findUserByLogin('user@user.com');

// Test
$I->amActingAs('admin@admin.com');
$I->wantTo('create a new group');
$I->amOnPage('/groups/create');
$I->seeElement('input', ['class' => 'form-control', 'name' => 'name']);
$I->fillField('name', 'Prozorovs');
$I->click('Create New Group');
$I->seeRecord('groups', [
    'name' => 'Prozorovs'
]);