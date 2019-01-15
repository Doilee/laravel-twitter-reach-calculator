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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reach(TweetUrl $request)
    {
        $reach = $this->calculateTweetReach($request->get('url'));

        return view('welcome', ['reach' => $reach]);
    }
}
