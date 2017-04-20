<?php
/**
 * Created by PhpStorm.
 * User: tangbiao
 * Date: 15-11-2
 * Time: 下午3:42
 */

class RabbitMQ {

    private static $_connection = null;

    private function __construct(){

    }

    private function __clone(){

    }

    /**
     * create a single connection
     */
    public static function instance(){

        if(is_null(self::$_connection)){
            self::$_connection = new AMQPConnection(array('host' => '127.0.0.1', 'port' => '5672', 'vhost' => 'abc', 'login' => 'guest', 'password' => 'guest'));
        }

        return self::$_connection;
    }

    /**
     * public a message to rabbitmq-server
     * @param $exchangeName
     * @param $routeKey
     * @param $message
     */
    public static function publish($exchangeName, $routeKey, $message){

        $connection = self::instance();
        $connection->connect();

        try {
            $channel = new AMQPChannel($connection);
            $exchange = new AMQPExchange($channel);
            $exchange->setName($exchangeName);

            #$queue = new AMQPQueue($channel);
            #$queue->setName($queueName);
            #$exchange->publish($message, $routeKey);
            $exchange->publish($message,$routeKey);

        } catch (AMQPConnectionException $e) {

        } finally {
            self::$_connection->disconnect();
        }

    }


}