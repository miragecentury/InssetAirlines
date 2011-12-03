#!/bin/bash
apt-get update
apt-get -y install apache2
apt-get -y install php5
apt-get -y install memcached
apt-get -y install php5-memcached
ln -s ../mods-available/cache.load ./
ln -s ../mods-available/mem_cache.* ./
ln -s ../mods-available/rewrite.load ./
ln -s ../mods-available/headers.load ./