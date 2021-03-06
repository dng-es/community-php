#!/usr/bin/env bash

apt-get update

#install Apache2
apt-get install -y apache2
if ! [ -L /var/www ]; then
  rm -rf /var/www
  ln -fs /vagrant/httpdocs /var/www
fi

#install MYSQLSERVER
debconf-set-selections <<< 'mysql-server mysql-server/root_password password Admin123'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password Admin123'
apt-get install -y mysql-server
if [ ! -f /var/log/databasesetup ];
then
    echo "CREATE USER 'comunidad'@'%' IDENTIFIED BY 'comunidad'" | mysql -uroot -pAdmin123
    echo "CREATE USER 'comunidad'@'localhost' IDENTIFIED BY 'comunidad'" | mysql -uroot -pAdmin123
    echo "CREATE DATABASE comunidad" | mysql -uroot -pAdmin123
    echo "GRANT ALL ON comunidad.* TO 'comunidad'@'%'" | mysql -uroot -pAdmin123
    echo "GRANT ALL ON comunidad.* TO 'comunidad'@'localhost'" | mysql -uroot -pAdmin123
    echo "flush privileges" | mysql -uroot -pAdmin123

    touch /var/log/databasesetup

    if [ -f /vagrant/bbdd.sql ];
    then
        mysql -uroot -pAdmin123 comunidad < /vagrant/bbdd.sql
    fi
fi


# install PHP5
apt-get install php5 libapache2-mod-php5 php5-mysql -y
 
# Restart Apache2
sudo /etc/init.d/apache2 restart
echo "ServerName comunidad.local.com" | sudo tee /etc/apache2/sites-available/fqdn.conf
sudo ln -s /etc/apache2/sites-available/fqdn.conf /etc/apache2/sites-enabled/fqdn.conf
 
# Restart Apache2 again
sudo /etc/init.d/apache2 restart

# Install FFmpeg
apt-get install ffmpeg -y