<?php
namespace console\components;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;

class RabbitMqHelper
{
    /**
     * @throws Exception
     */
    public static function publish($exchange, $queue, $routingKey, $data): void
    {
        $connection = static::getStreamConnection();
        $channel = $connection->channel();

        // Объявление exchange
        $channel->exchange_declare($exchange, 'direct', false, true, false);

        // Объявление очереди
        $channel->queue_declare($queue, false, true, false, false);

        // Привязка очереди к exchange по routing key
        $channel->queue_bind($queue, $exchange, $routingKey);

        $msg = new AMQPMessage(json_encode($data), ['delivery_mode' => 2]);
        $channel->basic_publish($msg, $exchange, $routingKey);

        $channel->close();
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public static function consume($exchange, $queue, $routingKey, callable $callback): void
    {

        $connection = static::getStreamConnection();

        $channel = $connection->channel();
        $channel->exchange_declare($exchange, 'direct', false, true, false);
        $channel->queue_declare($queue, false, true, false, false);
        $channel->queue_bind($queue, $exchange, $routingKey);
        $channel->basic_qos(0, 1, false);
        $channel->basic_consume($queue, '', false, true, false, false, function ($msg) use ($callback) {
            $callback(json_decode($msg->body, true));
        });

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    /**
     * @throws Exception
     */
    public static function getStreamConnection(): AMQPStreamConnection
    {
        $params = Yii::$app->params['rabbitmq'];

        return new AMQPStreamConnection(
            $params['host'],
            $params['port'],
            $params['user'],
            $params['pass'],
            '/',
            false,
            'AMQPLAIN',
            null,
            'en_US',
            3.0,
            3.0,
            null,
            false,
            (int)($params['heartbeat'] ?? 5)
        );
    }
}
