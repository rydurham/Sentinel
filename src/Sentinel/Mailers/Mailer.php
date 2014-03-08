<?php namespace Sentinel\Mailers;

use Mail, Queue;

abstract class Mailer {

	public function sendTo($email, $subject, $view, $data = array())
	{
		Queue::push(Mail::send($view, $data, function($message) use($email, $subject)
		{
			$message->to($email)
					->subject($subject);
		}));
	}
}