<?php

//before use this code you need install https://github.com/arnaud-lb/php-rdkafka

$rk = new RdKafka\Producer();
$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers("localhost:19092");

$topic = $rk->newTopic("test3");

$topic->produce(RD_KAFKA_PARTITION_UA, 0, "Message payload");

for ($i = 0; $i < 10; $i++) {
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, "Message $i");
    $rk->poll(0);
}

while ($rk->getOutQLen() > 0) {
    $rk->poll(50);
}