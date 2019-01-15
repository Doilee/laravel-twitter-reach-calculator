<?php

namespace App\Twitter;

use Twitter;

/**
 * Class MyTwitter
 * @package App\Twitter
 */
class MyTwitter extends Twitter
{
    public function __construct()
    {
        $params = [
            env('TWITTER_CONSUMER_KEY'),
            env('TWITTER_CONSUMER_SECRET'),
            env('TWITTER_ACCESS_TOKEN'),
            env('TWITTER_ACCESS_TOKEN_SECRET')
        ];

        parent::__construct(...$params);
    }
}