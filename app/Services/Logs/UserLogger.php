<?php
namespace App\Services\Logs;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Level;

class UserLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     */
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('users');
        $user = auth()->user();

        if ($user) {
            $logger->pushProcessor(function ($record) use ($user) {
                $record['extra']['user_id'] = $user->id;

                return $record;
            });
            $formatter = new JsonFormatter();
            $streamHandler = new StreamHandler(storage_path('logs/users.log'), Level::Info);
            $streamHandler->setFormatter($formatter);
            $logger->pushHandler($streamHandler);
        }

        return $logger;
    }
}
