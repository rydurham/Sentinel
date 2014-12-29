<?php namespace Sentinel\Traits;

use Config, Redirect, Response, Session;
use Sentinel\Services\Responders\BaseResponse;

trait SentinelRedirectionTrait {

    /**
     * Use a ResponseObject to generate a browser redirect, based on config options
     *
     * @param              $key
     * @param BaseResponse $response
     */
    public function answerFromResponse($key, BaseResponse $response)
    {

    }

    /**
     * Redirect the browser to the appropriate location, based on config options
     *
     * @param  int  $id
     * @return Response
     */
    public function answerWith($key, array $message = null, $payload = [])
    {
        // Determine where the developer wants us to go.
        $direction = Config::get('Sentinel::routing.' . $key);
        $url       = $this->urlLocator($direction);

        // Should this be a JSON response?
        if (! $url)
        {
            return Response::json($payload);
        }

        // Do we need to flash any data?
        if ($message)
        {
            $status = key($message);
            $text   = current($message);
            Session::flash($status,$text);
        }

        return Redirect::to($url)->with($payload);

    }

    public function urlLocator(array $direction)
    {
        $key      = key($direction);
        $location = current($direction);

        if (is_null($location))
        {
            return null;
        }

        return call_user_func($key, $location);
    }



}