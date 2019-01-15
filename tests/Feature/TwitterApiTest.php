<?php

namespace Tests\Feature;

use App\Http\Controllers\CalculatesTweetReach;
use Tests\TestCase;

/**
 * Class TwitterApiTest
 * @package Tests\Feature
 */
class TwitterApiTest extends TestCase
{
    use CalculatesTweetReach;

    /**
     * Test fetching retweets of a tweet that has 0 retweets
     */
    public function testFetchRetweetsOfExistingTweetWithoutRetweets()
    {
        $retweets = $this->getRetweets('1027577955181051904'); // https://twitter.com/Wonderkind/status/1027577955181051904

        $this->assertEmpty($retweets);
    }

    /**
     * Test fetching retweets of a tweet that has 3 retweets
     */
    public function testFetchRetweetsOfExistingTweetWithRetweets()
    {
        $retweets = $this->getRetweets('1014504621790978048'); // https://twitter.com/Wonderkind/status/1014504621790978048

        $this->assertCount(3, $retweets);
    }

    /**
     * Test a random non existing tweet
     */
    public function testFetchRetweetsOfNonExistingTweet()
    {
        $this->expectException(\TwitterException::class);

        $this->getRetweets('123123123123123123123');
    }
}
