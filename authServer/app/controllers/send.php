<?php

/**
 * PHP amqp(RabbitMQ) Demo-1
 * @author  yuansir <yuansir@live.cn/yuansir-web.com>
 */
function send($rabbitmqhost, $rabbitmqport, $rabbitmquser, $rabbitmqpassword, $queueName, $message)
{
	$exchangeName = 'demo';
	$routeKey = $queueName;

	$connection = new AMQPConnection(array('host' => $rabbitmqhost, 'port' => $rabbitmqport, 'vhost' => 'abc', 'login' => $rabbitmquser, 'password' => $rabbitmqpassword));
	$connection->connect() or die("Cannot connect to the broker!\n");

	try {
			$channel = new AMQPChannel($connection);
			$exchange = new AMQPExchange($channel);
			$exchange->setName($exchangeName);
			$queue = new AMQPQueue($channel);
			$queue->setName($queueName);
			$exchange->publish($message, $routeKey);
	} catch (AMQPConnectionException $e) {
			var_dump($e);
			exit();
	}
	$connection->disconnect();
}

function send2rabbitmq($address, $queueName, $message)
{
	$allClients = Client::all();
	$rabbitmqhost = $_ENV['RABBITMQ_HOST'];
	$rabbitmqport = $_ENV['RABBITMQ_PORT'];
	$rabbitmquser = $_ENV['RABBITMQ_USER'];
	$rabbitmqpassword = $_ENV['RABBITMQ_PASSWORD'];
	
	foreach($allClients as $allClient)
	{
		//file_put_contents('test.txt', $allClient->id, FILE_APPEND);
		send($rabbitmqhost, $rabbitmqport, $rabbitmquser, $rabbitmqpassword, $allClient->id, $message);
	}
}
?>
