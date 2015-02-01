<?php namespace Sentinel\Http\FormRequests;

use App\Http\Requests\Request;

class ChangePasswordRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'oldPassword'              => 'min:8',
            'newPassword'              => 'required|min:8|confirmed',
            'newPassword_confirmation' => 'required'
		];
	}

}
