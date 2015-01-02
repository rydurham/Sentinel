<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{

    public function amActingAs($email)
    {
        $sentry = $this->getModule('Laravel4')->grabService('sentry');
        $session = $this->getModule('Laravel4')->grabService('session');
        $session->start();
        $user = $sentry->findUserByLogin($email);
        $sentry->login($user);
        $session->put('userId', $user->id);
        $session->put('email', $user->email);
    }
}
