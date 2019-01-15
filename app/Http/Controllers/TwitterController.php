<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetUrl;

/**
 * Class TwitterController
 * @package App\Http\Controllers
 */
class TwitterController extends Controller
{
    use CalculatesTweetReach;

    /**
     * @param TweetUrl $request
     *
     * @return \Illuminate\View\View
     */
    public function reach(TweetUrl $request) : \Illuminate\View\View
    {
        $reach = $this->getReachFromUrl($request->get('url'));

        return view('welcome', ['reach' => $reach]);
    }
}
