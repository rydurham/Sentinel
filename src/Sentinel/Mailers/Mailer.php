<?php namespace Sentinel\Mailers;

use Mail;

abstract class Mailer {

	public function sendTo($email, $subject, $view, $data = array())
	{
		Mail::queue($view, $data, function($message) use($email, $subject)
		{
			$message->to($email)
					->subject($subject);
		});
	}
}