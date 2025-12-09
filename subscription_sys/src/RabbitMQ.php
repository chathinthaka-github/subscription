<?php

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQ
{
    private static ?AMQPStreamConnection $connection = null;
    private static array $channels = [];

    public static function getConnection(): AMQPStreamConnection
    {
        if (self::$connection === null) {
            $host = Config::get('RABBITMQ_HOST', '127.0.0.1');
            $port = (int)Config::get('RABBITMQ_PORT', '5672');
            $user = Config::get('RABBITMQ_USER', 'guest');
            $pass = Config::get('RABBITMQ_PASS', 'guest');
            $vhost = Config::get('RABBITMQ_VHOST', '/');

            try {
                self::$connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
            } catch (\Exception $e) {
                throw new \RuntimeException("RabbitMQ connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function getChannel(): AMQPChannel
    {
        $connection = self::getConnection();
        $channelId = spl_object_id($connection);
        
        if (!isset(self::$channels[$channelId])) {
            self::$channels[$channelId] = $connection->channel();
        }

        return self::$channels[$channelId];
    }

    public static function publish(string $queue, array $data): void
    {
        $channel = self::getChannel();
        $channel->queue_declare($queue, false, true, false, false);

        $message = new AMQPMessage(
            json_encode($data),
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        $channel->basic_publish($message, '', $queue);
    }

    public static function close(): void
    {
        foreach (self::$channels as $channel) {
            $channel->close();
        }
        self::$channels = [];

        if (self::$connection !== null) {
            self::$connection->close();
            self::$connection = null;
        }
    }
}

