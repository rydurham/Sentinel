<?php namespace Sentinel\Composers;

use Sentinel\Repo\User\UserInterface;
use Session;

class SuspendComposer {

    protected $user;

    public function __construct( UserInterface $user )
    {
        $this->user = $user;
    }

    public function compose($view)
    {
        // view data contains user_id
        $viewdata= $view->getData();

        // Pull data about the user being suspended
        $user = $this->user->byId($viewdata['user_id']); 
       
        $view->with('user', $user);
    }

}