<?php namespace Sentinel\Repositories\Session;

use Sentinel\Services\Responders\BaseResponse;

interface SentinelSessionManagerInterface {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return BaseResponse
	 */
	public function store($data);

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return BaseResponse
	 */
	public function destroy();

}