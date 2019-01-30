<?php

namespace App\Console\Commands;

use App\Keyword;
use App\Tweet;
use Illuminate\Console\Command;
use Spatie\TwitterStreamingApi\PublicStream;

class StreamTwitter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'StreamTwitter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stream twitter';

    protected $twitterStream;

    /**
     * StreamTwitter constructor.
     * @param TwitterStream $twitterStream
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        }

        $keywords = Keyword::where('disable', false)->pluck('str')->toArray();
        if (sizeof($keywords) > 0) {
            PublicStream::create(
                config('ttwitter.STREAM_ACCESS_TOKEN'),
                config('ttwitter.STREAM_ACCESS_TOKEN_SECRET'),
                config('ttwitter.STREAM_CONSUMER_KEY'),
                config('ttwitter.STREAM_CONSUMER_SECRET')
            )->whenHears($keywords, function (array $tweet) {
                $user_screen_name = isset($tweet['user']['screen_name']) ? $tweet['user']['screen_name'] : null;

                if (isset($tweet['id'])) {
                    Tweet::create([
                        'tweet_id' => $tweet['id_str'],
                        'tweet_created_at' => $tweet['created_at'],
                        'tweet_text' => $tweet['text'],
                        'json' => json_encode($tweet),
                        'user_id' => $tweet['user']['id_str'],
                        'user_created_at' => $tweet['user']['created_at'],
                        'user_screen_name' => $tweet['user']['screen_name'],
                        'user_name' => $tweet['user']['name'],
                        'profile_image_url' => $tweet['user']['profile_image_url'],
                        'city' => $tweet['user']['city'],
                        'location' => $tweet['user']['location'],
                        'url' => $tweet['user']['url'],
                        'description' => $tweet['user']['description'],
                        'verified' => $tweet['user']['verified'],
                        'followers_count' => $tweet['user']['followers_count'],
                        'friends_count' => $tweet['user']['friends_count'],
                        'statuses_count' => $tweet['user']['statuses_count'],
                        'lang' => $tweet['user']['lang'],
                        'geo' => $tweet['user']['geo'],
                        'coordinates' => $tweet['user']['coordinates'],
                        'place' => $tweet['user']['place'],
                   ]);
                }
            })->startListening();
        }
    }
}
