<?php namespace Sentinel\Traits;

use Config, Redirect, Response, Session;
use Sentinel\Services\Responders\BaseResponse;

trait SentinelRedirectionTrait {

    /**
     * Use a ResponseObject to generate a browser redirect, based on config options
     *
     * @param              $key
     * @param BaseResponse $response
     *
     * @return Response
     */
    public function answerWithResponse($key, BaseResponse $response)
    {
        if ($response->isSuccessful())
        {
            $message = ['success' => $response->getMessage()];
        }
        else
        {
            $message = ['error' => $response->getMessage()];
        }
        return $this->redirectTo($key, $message, $response->getPayload());

    }

    /**
     * Redirect the browser to the appropriate location, based on config options
     *
     * @param  int  $id
     * @return Response
     */
    public function redirectTo($key, array $message = null, $payload = [])
    {
        // A key can either be a string representing a config entry, or
        // an array representing the "direction" we intend to go in.
        $direction = (is_array($key) ? $key : Config::get('Sentinel::routing.' . $key));

        // Convert this "direction" to a url
        $url = $this->generateUrl($direction);

        // If the url is null (or blank) the developer wants to return
        // json rather than a view request.
        if (! $url) { return Response::json($payload); }

        // Do we need to flash any session data?
        if ($message)
        {
            $status = key($message);
            $text   = current($message);
            Session::flash($status,$text);
        }

        // Redirect to the intended url
        return Redirect::to($url)->with($payload);

    }

    /**
     * Generate URL from an array found in the config file
     *
     * @param array $direction
     *
     * @return string|null
     */
    public function generateUrl(array $direction)
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