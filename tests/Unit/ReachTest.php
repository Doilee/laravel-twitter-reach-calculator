<?php

namespace Tests\Unit;

use App\Http\Controllers\CalculatesTweetReach;
use App\Http\Controllers\TwitterController;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * Class ReachTest
 * @package Tests\Unit
 */
class ReachTest extends TestCase
{
    use CalculatesTweetReach;

    /**
     * Test the retweet count from a tweet made at 21 dec 2018
     * by donald trump showing the blueprints of America's beautiful big wall ;-)
     */
    public function testPopularTweet()
    {
        $reach = $this->getReachFromUrl('https://twitter.com/realDonaldTrump/status/1076239448461987841');

        $this->assertGreaterThan(15000, $reach['count']); // At the time of making this test it's 33606

        $this->assertCount(92, $reach['retweeters']); // At the time of making this test it's 92 (limit to 92)
    }

    /**
     * Test the retweet count from a tweet made at 27 dec 2018
     * by Nutrition Facts showing a thank you image for their supporters! ;-)
     * (Check it out btw, great unbiased information on Nutrition!)
     */
    public function testLessPopularTweet()
    {
        $reach = $this->getReachFromUrl('https://twitter.com/nutrition_facts/status/1078327187202367490');

        $this->assertLessThan(15000, $reach['count']); // At the time of making this test it's 14172

        $this->assertCount(7, $reach['retweeters']); // At the time of making this test it's 92 (limit to 92)
    }

    /**
     * Test validation on a correct twitter URL
     */
    public function testCorrectUrlValidation()
    {
        $this->validateTwitterUrl('https://twitter.com/nutrition_facts/status/1078327187202367490');

        $this->assertTrue(true);
    }

    /**
     * Test validation on an incorrect twitter URL
     */
    public function testIncorrectUrlValidation()
    {
        $this->expectException(ValidationException::class);

        $this->validateTwitterUrl('https://tweetboy.com/nutrition_facts/status/1078327187202367490');
    }

    /**
     * Tests if Cache result is stored
     */
    public function testCacheResults() {
        Cache::shouldReceive('has')
            ->once()
            ->with('tweet-1027577955181051904')
        ;
        Cache::shouldReceive('put')
            ->once()
            ->with('tweet-1027577955181051904', ['count' => 0, 'retweeters' => []], 120);

        $this->getReachFromUrl('https://twitter.com/wonderkind/status/1027577955181051904');
    }
}
