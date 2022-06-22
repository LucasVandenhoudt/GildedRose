#!/bin/bash

qa()
{
    docker run \
        --init \
        --rm \
        -ti \
        -v "$(pwd):/usr/src" \
        -v "$(pwd)/tmp-phpqa:/tmp" \
        -v "$(pwd)/bin/php.ini:/usr/local/etc/php/php.ini" \
        -w /usr/src jakzal/phpqa:php7.4 "$@"
}
