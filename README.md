# http2mqtt

http2mqtt is a simple http to mqtt bridge to publish HTTP Post Requests to a MQTT Broker.

usage to start the server via internal php server
> git clone git@github.com:oliverlorenz/http2mqtt.git
> cd http2mqtt
> composer install
> php -S 127.0.0.1:8000 index.php

for testing: Send a POST-Request to a freely choosen route with some data
> curl -H "Content-Type: application/json" -X POST -d '{"key":"value"}' http://localhost:8000/my/topic/for/mqtt
