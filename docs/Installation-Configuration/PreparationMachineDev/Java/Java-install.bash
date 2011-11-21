#!/bin/bash

apt-get -y update
apt-get -y remove openjdk-6-jre
apt-get -y remove openjdk-6-jre-headless
apt-get -y remove openjdk-6-jre-lib

cd /root/
mkdir ./install
cd ./install/
wget http://download.oracle.com/otn-pub/java/jdk/6u27-b07/jdk-6u27-linux-x64.bin
mkdir /usr/java/
cp ./jdk-6u27-linux-x64.bin /usr/java/
chmod +x /usr/java/jdk-6u27-linux-x64.bin
cd /usr/java/
./jdk-6u27-linux-x64.bin
#Press Enter
rm ./jdk-6u27-linux-x64.bin
cd /root/install/
wget http://download.oracle.com/otn-pub/java/jdk/7/jdk-7-linux-x64.tar.gz
tar xzvf ./jdk-7-linux-x64.tar.gz
mv ./jdk1.7.0 /usr/java/
cd /bin/
ln -s /usr/java/jdk1.6.0_27/bin/java* /usr/bin/
ln -s /usr/java/jdk1.6.0_27/bin/java* /bin/




