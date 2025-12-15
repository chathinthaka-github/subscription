<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

require_once __DIR__ . '/Config.php';
require_once __DIR__ . '/Logger.php';

class RabbitMQ
{
    private static $connection = null;
    private static $channel = null;
    private static $config = null;

    /**
     * Get connection
     */
    private static function getConnection()
    {
        if (self::$connection === null || !self::$connection->isConnected()) {
            try {
                $config = Config::rabbitmq();
                self::$connection = new AMQPStreamConnection(
                    $config['host'],
                    $config['port'],
                    $config['user'],
                    $config['password'],
                    $config['vhost']
                );
                Logger::info('RabbitMQ connection established');
            } catch (Exception $e) {
                Logger::error('RabbitMQ connection failed', ['error' => $e->getMessage()]);
                throw $e;
            }
        }
        return self::$connection;
    }

    /**
     * Get channel
     */
    private static function getChannel()
    {
        if (self::$channel === null || !self::$connection->isConnected()) {
            self::$channel = self::getConnection()->channel();
        }
        return self::$channel;
    }

    /**
     * Declare queue if not exists
     */
    private static function declareQueue($queueName)
    {
        $channel = self::getChannel();
        $channel->queue_declare(
            $queueName,
            false,  // passive
            true,   // durable
            false,  // exclusive
            false   // auto_delete
        );
    }

    /**
     * Publish message to queue
     */
    public static function publish($queueName, $message, $persistent = true)
    {
        try {
            self::declareQueue($queueName);
            $channel = self::getChannel();

            $messageBody = is_array($message) ? json_encode($message) : $message;
            $properties = [
                'delivery_mode' => $persistent ? AMQPMessage::DELIVERY_MODE_PERSISTENT : AMQPMessage::DELIVERY_MODE_NON_PERSISTENT
            ];

            $msg = new AMQPMessage($messageBody, $properties);
            $channel->basic_publish($msg, '', $queueName);

            Logger::info('Message published to queue', ['queue' => $queueName, 'message' => $messageBody]);
            return true;
        } catch (Exception $e) {
            Logger::error('Failed to publish message', [
                'queue' => $queueName,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Consume messages from queue
     */
    public static function consume($queueName, $callback, $autoAck = false)
    {
        try {
            self::declareQueue($queueName);
            $channel = self::getChannel();

            $channel->basic_qos(null, 1, null); // Process one message at a time

            $channel->basic_consume(
                $queueName,
                '',      // consumer_tag
                false,   // no_local
                $autoAck, // no_ack
                false,   // exclusive
                false,   // no_wait
                function ($msg) use ($callback, $channel, $autoAck) {
                    try {
                        $body = json_decode($msg->body, true);
                        if ($body === null && json_last_error() !== JSON_ERROR_NONE) {
                            $body = $msg->body; // Fallback to raw string
                        }

                        $result = call_user_func($callback, $body, $msg);

                        if (!$autoAck) {
                            if ($result !== false) {
                                $msg->ack();
                            } else {
                                $msg->nack(false, true); // Requeue on failure
                            }
                        }
                    } catch (Exception $e) {
                        Logger::error('Error processing message', [
                            'queue' => $queueName,
                            'error' => $e->getMessage(),
                            'body' => $msg->body
                        ]);
                        if (!$autoAck) {
                            $msg->nack(false, true); // Requeue on exception
                        }
                    }
                }
            );

            Logger::info('Started consuming queue', ['queue' => $queueName]);

            while ($channel->is_consuming()) {
                $channel->wait();
            }
        } catch (Exception $e) {
            Logger::error('Failed to consume from queue', [
                'queue' => $queueName,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Close connection
     */
    public static function close()
    {
        try {
            if (self::$channel !== null) {
                self::$channel->close();
                self::$channel = null;
            }
            if (self::$connection !== null) {
                self::$connection->close();
                self::$connection = null;
            }
            Logger::info('RabbitMQ connection closed');
        } catch (Exception $e) {
            Logger::error('Error closing RabbitMQ connection', ['error' => $e->getMessage()]);
        }
    }
}

