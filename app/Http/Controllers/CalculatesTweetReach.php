<?php

namespace App\Http\Controllers;

use App\Twitter\MyTwitter;
use Dotenv\Exception\ValidationException;

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
     * @return array
     */
    protected function calculateTweetReach($url) : array
    {
        $this->validateTwitterUrl($url);

        $id = array_last(explode('/', $url));

        $retweets = $this->getRetweets($id);

        $retweeters = array_pluck($retweets, 'user');
        $followers_count_sum = array_sum(array_pluck($retweeters, 'followers_count'));

        return [
            'count' => $followers_count_sum,
            'retweeters' => $retweeters
        ];
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
}
