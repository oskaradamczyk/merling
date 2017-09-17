#!/bin/bash

export DOCKER_HOST_IP="$(ip -o -4 addr list docker0 | awk '{print $4}' | cut -d/ -f1)"
export DOCKER_XDEBUG=yes
docker-compose up