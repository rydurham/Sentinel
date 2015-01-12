<?php namespace Sentinel\Traits;

use Config, Redirect, Response, View;

trait SentinelViewfinderTrait {

    /**
     * Before returning an HTML view, we need to make sure the developer has not
     * specified that we only use JSON responses.
     *
     * @param       $theme
     * @param array $payload
     *
     * @return Response
     */
    public function viewFinder($view, $payload = [])
    {
        // Check the config for enabled views
        if (Config::get('Sentinel::views.enabled'))
        {
            // Views are enabled.
            return View::make($view)->with($payload);
        }
        else
        {
            // Check the payload for paginator instances.
            foreach ($payload as $name => $item) {
                if ($item instanceof \Illuminate\Pagination\Paginator) {
                    $payload[$name] = $item->getCollection();
                }
            }

            return Response::json($payload);
        }
    }
}