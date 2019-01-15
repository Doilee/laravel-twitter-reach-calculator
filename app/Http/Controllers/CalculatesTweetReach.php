<?php

namespace App\Http\Controllers;

use App\Twitter\MyTwitter;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Cache;

/**
 * Trait CalculatesTweetReach
 * @package App\Http\Controllers
 */
trait CalculatesTweetReach
{
    protected $allowed_urls = [
        'twitter.com'
    ];

    /**
     * @param $url
     *
     * @return string
     */
    protected function getTweetIdFromUrl($url) : string
    {
        return array_last(explode('/', $url));
    }

    /**
     * @param $url
     *
     * @return array
     */
    protected function getReachFromUrl($url) : array
    {
        $this->validateTwitterUrl($url);

        $id = $this->getTweetIdFromUrl($url);

        if (Cache::has('tweet-' . $id))
            return Cache::get('tweet-' . $id);

        $retweets = $this->getRetweets($id);

        $reach = $this->calculateReachFromRetweets($retweets);

        Cache::put('tweet-' . $id, $reach, 120);

        return $reach;
    }

    /**
     * @param $url
     */
    protected function validateTwitterUrl($url)
    {
        $url = parse_url($url);

        if (!in_array($url['host'], $this->allowed_urls))
            throw new ValidationException('Please provide a Twitter URL');

        if (count(explode('/', $url['path'])) != 4)
            throw new ValidationException('Please provide the URL of a tweet');
    }

    /**
     * @param $id
     *
     * @return array
     */
    protected function getRetweets($id) : array
    {
        return (new MyTwitter)->request('statuses/retweets/' .  $id , 'GET', ['count' => 100]);
    }

    /**
     * @param $retweets
     *
     * @return array
     */
    protected function calculateReachFromRetweets($retweets) : array
    {
        $retweeters = array_pluck($retweets, 'user');
        $followers_count_sum = array_sum(array_pluck($retweeters, 'followers_count'));

        $reach = [
            'count'      => $followers_count_sum,
            'retweeters' => $retweeters
        ];

        return $reach;
    }
}
