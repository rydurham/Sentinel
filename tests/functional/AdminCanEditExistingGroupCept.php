<?php 
$I = new FunctionalTester($scenario);

// Prep
$sentry = $I->grabService('sentry');
$user = $sentry->findUserByLogin('user@user.com');
$group = $sentry->findGroupByName('Users');

// Test
$I->amActingAs('admin@admin.com');
$I->wantTo('edit a group name');
$I->amOnPage('/groups/' . $group->id . '/edit');
$I->seeElement('input', ['class' => 'form-control', 'name' => 'name']);
$I->fillField('name', 'Prozorovs');
$I->click('Save Changes');
$I->seeRecord('groups', [
    'name' => 'Prozorovs',
    'id'   => $group->id
]);