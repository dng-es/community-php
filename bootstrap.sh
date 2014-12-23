#!/usr/bin/env bash

sudo yum update -y
sudo yum install httpd -y
#if ! [ -L /var/www ]; then
#  sudo rm -rf /var/www
#  sudo ln -fs /vagrant/httpdocs /var/www
#fi

#instalación MYSQL-SERVER
sudo yum install mysql-server -y
sudo service mysqld start
if [ ! -f /var/log/databasesetup ];
then
    echo "CREATE USER 'comunidad'@'%' IDENTIFIED BY 'comunidad'" | mysql -u root
    echo "CREATE DATABASE comunidad" | mysql -u root
    echo "GRANT ALL ON comunidad.* TO 'comunidad'@'%'" | mysql -u root
    echo "flush privileges" | mysql -u root

    touch /var/log/databasesetup

    if [ -f /vagrant/bbdd.sql ];
    then
        mysql -u root comunidad < /vagrant/bbdd.sql
    fi
fi


# instalación PHP5
sudo yum install php php-mysql -y
 
 
# iniciar servicios
sudo service httpd start
sudo service mysqld start
sudo service iptables stop



