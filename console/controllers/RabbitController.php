<?php
namespace console\controllers;

use yii\console\Controller;
use console\components\RabbitMqHelper;

class RabbitController extends Controller
{
    public const EXCHANGE = 'indexy_exchange';
    public const QUEUE = 'indexy_queue';
    public const ROUTING_KEY = 'indexy_routing_key';

    /**
     * @throws \Exception
     */
    public function actionSend(): void
    {
        RabbitMqHelper::publish(self::EXCHANGE,self::QUEUE,self::ROUTING_KEY,
            ['message' => 'Test message', 'time' => time()]);
        echo " [x] Сообщение отправлено\n";
    }

    /**
     * @throws \Exception
     */
    public function actionConsume(): void
    {
        echo " [*] Ожидание сообщений. Нажмите CTRL+C для выхода\n";

        RabbitMqHelper::consume(self::EXCHANGE,self::QUEUE,self::ROUTING_KEY, function ($data) {
            echo " [x] Получено сообщение: " . json_encode($data) . "\n";
        });
    }
}
