<?php

namespace Tests\Unit;

use App\Http\Controllers\CalculatesTweetReach;
use Dotenv\Exception\ValidationException;
use Tests\TestCase;

class ReachTest extends TestCase
{
    use CalculatesTweetReach;

    /**
     * Test the retweet count from a tweet made at 21 dec 2018
     * by donald trump showing the blueprints of America's beautiful big wall ;-)
     */
    public function testPopularTweet()
    {
        // dd($this->getRetweets('1076239448461987841'));
        $reach = $this->calculateTweetReach('https://twitter.com/realDonaldTrump/status/1076239448461987841');

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
        $reach = $this->calculateTweetReach('https://twitter.com/nutrition_facts/status/1078327187202367490');

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
}
