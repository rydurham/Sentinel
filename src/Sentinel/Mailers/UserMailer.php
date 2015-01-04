<?php namespace Sentinel\Mailers;

use Config;

class UserMailer extends Mailer {

	/**
	 * Outline all the events this class will be listening for. 
	 * @param  [type] $events 
	 * @return void         
	 */
	public function subscribe($events)
	{
		$events->listen('sentinel.user.registered', 	'Sentinel\Mailers\UserMailer@welcome', 10);
		$events->listen('sentinel.user.resend', 		'Sentinel\Mailers\UserMailer@welcome', 10);
		$events->listen('sentinel.user.reset',			'Sentinel\Mailers\UserMailer@passwordReset', 10);
	}

    /**
     * Send a welcome email to a new user.
     *
     * @param $user
     * @param $activated
     *
     * @return bool
     * @internal param string $email
     * @internal param int $userId
     * @internal param string $activationCode
     */
	public function welcome($user, $activated)
	{
        $subject = Config::get('Sentinel::email.welcome');
		$view = 'Sentinel::emails.welcome';
		$data['userId'] = $user->id;
		$data['activationCode'] = $user->getActivationCode();
		$data['email'] = $user->email;

		if (! $activated)
		{
            $this->sendTo( $user->email, $subject, $view, $data );
		}
		
	}

    /**
     * Email Password Reset info to a user.
     *
     * @param $user
     * @param $code
     *
     * @internal param string $email
     * @internal param int $userId
     * @internal param string $resetCode
     */
	public function passwordReset($user, $code)
	{
		$subject = Config::get('Sentinel::email.reset_password');
		$view = 'Sentinel::emails.reset';
		$data['userId'] = $user->id;
		$data['code'] = $code;
		$data['email'] = $user->email;

		$this->sendTo($user->email, $subject, $view, $data );
	}

}