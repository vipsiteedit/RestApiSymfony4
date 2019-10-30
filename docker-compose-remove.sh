#! /usr/bin/bash

docker stop w2_mysql_1
docker stop w2_nginx_1
docker stop w2_pma_1
docker stop w2_php_1
docker rm -v $(docker ps -aq -f status=exited)