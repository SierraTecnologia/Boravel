<?php

namespace Boss;

use Closure;
use Exception;

class Boss
{
    /**
     * The callback that should be used to authenticate Boss users.
     *
     * @var \Closure
     */
    public static $authUsing;

    /**
     * The Slack notifications webhook URL.
     *
     * @var string
     */
    public static $slackWebhookUrl;

    /**
     * The Slack notifications channel.
     *
     * @var string
     */
    public static $slackChannel;

    /**
     * The SMS notifications phone number.
     *
     * @var string
     */
    public static $smsNumber;

    /**
     * The email address for notifications.
     *
     * @var string
     */
    public static $email;

    /**
     * Indicates if Boss should use the dark theme.
     *
     * @var bool
     */
    public static $useDarkTheme = false;

    /**
     * The database configuration methods.
     *
     * @var array
     */
    public static $databases = [
        'Jobs', 'Supervisors', 'CommandQueue', 'Tags',
        'Metrics', 'Locks', 'Processes',
    ];

    /**
     * Determine if the given request can access the Boss dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function check($request)
    {
        return (static::$authUsing ?: function () {
            return app()->environment('local');
        })($request);
    }

    /**
     * Set the callback that should be used to authenticate Boss users.
     *
     * @param  \Closure  $callback
     * @return static
     */
    public static function auth(Closure $callback)
    {
        static::$authUsing = $callback;

        return new static;
    }

    /**
     * Configure the Redis databases that will store Boss data.
     *
     * @param  string  $connection
     * @return void
     * @throws Exception
     */
    public static function use($connection)
    {
        if (! is_null($config = config("database.redis.clusters.{$connection}.0"))) {
            config(["database.redis.{$connection}" => $config]);
        } elseif (is_null($config) && is_null($config = config("database.redis.{$connection}"))) {
            throw new Exception("Redis connection [{$connection}] has not been configured.");
        }

        config(['database.redis.boss' => array_merge($config, [
            'options' => ['prefix' => config('boss.prefix') ?: 'boss:'],
        ])]);
    }

    /**
     * Specifies that Boss should use the dark theme.
     *
     * @return static
     */
    public static function night()
    {
        static::$useDarkTheme = true;

        return new static;
    }

    /**
     * Get the default JavaScript variables for Boss.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path' => config('boss.path'),
            'timezone' => config('app.timezone'),
        ];
    }

    /**
     * Specify the email address to which email notifications should be routed.
     *
     * @param  string  $email
     * @return static
     */
    public static function routeMailNotificationsTo($email)
    {
        static::$email = $email;

        return new static;
    }

    /**
     * Specify the webhook URL and channel to which Slack notifications should be routed.
     *
     * @param  string  $url
     * @param  string  $channel
     * @return static
     */
    public static function routeSlackNotificationsTo($url, $channel = null)
    {
        static::$slackWebhookUrl = $url;
        static::$slackChannel = $channel;

        return new static;
    }

    /**
     * Specify the phone number to which SMS notifications should be routed.
     *
     * @param  string  $number
     * @return static
     */
    public static function routeSmsNotificationsTo($number)
    {
        static::$smsNumber = $number;

        return new static;
    }
}
