<?php

namespace Sentinel\Traits;

use Request;
use Session;
use Redirect;
use Response;
use Sentinel\DataTransferObjects\BaseResponse;

trait SentinelRedirectionTrait
{
    /**
     * Use a ResponseObject to generate a browser redirect, based on config options
     *
     * @param              $key
     * @param BaseResponse $response
     *
     * @return Response
     */
    public function redirectViaResponse($key, BaseResponse $response)
    {
        if ($response->isSuccessful()) {
            $message = ['success' => $response->getMessage()];
        } else {
            $message = ['error' => $response->getMessage()];
        }

        // Was an error caught? If so we need to redirect back.
        if ($response->isError()) {
            return $this->redirectBack($message, $response->getPayload());
        }

        return $this->redirectTo($key, $message, $response->getPayload());
    }

    /**
     * Redirect the browser to the appropriate location, based on config options
     *
     * @param       $key
     * @param array $message
     * @param array $payload
     *
     * @return Response
     */
    public function redirectTo($key, array $message = [], $payload = [])
    {
        // A key can either be a string representing a config entry, or
        // an array representing the "direction" we intend to go in.
        $direction = (is_array($key) ? $key : config('sentinel.routing.' . $key));

        // Convert this "direction" to a url
        $url = $this->generateUrl($direction, $payload);

        // Determine if the developer has disabled HTML views
        $views = config('sentinel.views_enabled');

        // If the url is empty or views have been disabled the developer
        // wants to return json rather than an HTML view.
        if (! $url || !$views || Request::ajax() || Request::pjax()) {
            return Response::json(array_merge($payload, $message));
        }

        // Do we need to flash any session data?
        if ($message) {
            $status = key($message);
            $text   = current($message);
            Session::flash($status, $text);
        }

        // Redirect to the intended url
        return Redirect::to($url)->with($payload);
    }

    /**
     * Redirect back to the previous page.
     *
     * @param $message
     * @param $payload
     */
    public function redirectBack($message, $payload = [])
    {
        // Determine if the developer has disabled HTML views
        $views = config('sentinel.views_enabled');

        // If views have been disabled, return a JSON response
        if (!$views || Request::ajax() || Request::pjax()) {
            return Response::json(array_merge($payload, $message), 400);
        }

        // Do we need to flash any session data?
        if ($message) {
            $status = key($message);
            $text   = current($message);
            Session::flash($status, $text);
        }

        // Go back
        return redirect()->back()->withInput()->with($payload);
    }

    /**
     * Generate URL from an array found in the config file
     *
     * @param array $direction
     *
     * @return string|null
     */
    public function generateUrl(array $direction, array $payload = [])
    {
        // Do we need to pull any data from the payload to build the url?
        $parameters = (isset($direction['parameters']) ? $this->extractParameters($direction['parameters'], $payload) : []);
        unset($direction['parameters']);

        // Determine how the URL has been referenced
        $key      = key($direction);
        $location = current($direction);

        // If no URL target was specified we can't do anything.
        if (is_null($location)) {
            return null;
        }

        return call_user_func_array($key, array_merge([$location], $parameters));
    }

    /**
     * Extract URL data from the payload
     *
     * @param $specifications
     * @param $payload
     *
     * @return array
     */
    public function extractParameters($specifications, $payload)
    {
        $parameters = [];

        foreach ($specifications as $name => $member) {
            if (isset($payload[$name])) {
                $parameters[] = $payload[$name]->$member;
            }
        }

        return $parameters;
    }
}
