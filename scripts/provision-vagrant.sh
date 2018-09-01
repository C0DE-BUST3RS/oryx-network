#!/usr/bin/env bash

APP_DATABASE_NAME='app'

echo "============= Starting Provisioning Script ============="

echo ">>>>>>>>> Update packages"
sudo apt-get update

echo ">>>>>>>>> Installing packages"

# Install base items
sudo apt-get install -y tmux curl wget build-essential python-software-properties

echo ">>>>>>>>> Adding Personal Package Archives (PPA's) for latest PHP"

sudo LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php

echo ">>>>>>>>> Update packages Again"
sudo apt-get update

echo ">>>>>>>>> Setting MySQL (username: root) ~ (password: root)"
sudo debconf-set-selections <<< 'mysql-server-5.6 mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server-5.6 mysql-server/root_password_again password root'


echo ">>>>>>>>> Install the Rest of the packages"
sudo apt-get install -y curl php7.1 apache2 libapache2-mod-php7.1 php7.1-curl php7.1-gd php7.1-mcrypt php7.1-readline php7.1-mbstring php7.1-bcmath zip unzip php7.1-zip mysql-server mysql-client mysql-common php7.1-mysql git-core


echo ">>>>>>>>> Install more locales (NL)"
sudo locale-gen nl_NL
sudo locale-gen nl_NL.UTF-8
sudo update-locale

echo "============= Configure Server ============="

echo ">>>>>>>>> Create a virtual host file template in the sites-available folder for Apache"
sudo cat << EOF | sudo tee /etc/apache2/sites-available/virtual-host.conf
<VirtualHost *:80>
    ServerName vhost.local
    DocumentRoot /var/www/app
    ErrorLog /var/log/apache2/vhost.log
    TransferLog /var/log/apache2/vhost.log
    <Directory /var/www/app>
        Options +Indexes +FollowSymLinks +MultiViews
        IndexOptions FancyIndexing FoldersFirst NameWidth=* DescriptionWidth=*
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>
</VirtualHost>
EOF

echo ">>>>>>>>> Enable / Disable modules and Virtual hosts"
sudo a2enmod rewrite
sudo a2ensite virtual-host
sudo a2dissite 000-default

echo ">>>>>>>>> Configure PHP"
sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.1/apache2/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.1/apache2/php.ini
sudo sed -i "s/disable_functions = .*/disable_functions = /" /etc/php/7.1/cli/php.ini

echo ">>>>>>>>> Restart Apache"
sudo service apache2 restart


echo ">>>>>>>>> Configure MySQL by accepting incoming connections"
sudo sed -i 's/bind-address/#bind-address/g' /etc/mysql/my.cnf

echo ">>>>>>>>> Restart MySQL"
sudo service mysql restart

echo ">>>>>>>>> Pre create a database called: '$APP_DATABASE_NAME'"
mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS $APP_DATABASE_NAME DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;"
mysql -uroot -proot -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root';"
mysql -uroot -proot -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED BY 'root';"

## Optional to load an SQL file from Host machine
# echo ">>>>>>>>> Import SQL file"
# mysql -uroot -ppassword database < my_database.sql

echo ">>>>>>>>> Install Composer"
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
composer self-update

#!/bin/sh -e

export DEBIAN_FRONTEND=noninteractive

PROVISIONED_ON=/etc/vm_provision_on_timestamp
if [ -f "$PROVISIONED_ON" ]
then
  echo "VM was already provisioned at: $(cat $PROVISIONED_ON)"
  echo "To run system updates manually login via 'vagrant ssh' and run 'apt-get update && apt-get upgrade'"
  echo ""
  print_db_usage
  exit
fi

# Tag the provision time:
date > "$PROVISIONED_ON"

print_db_usage

echo ">>>>>>>>> Cleaning up"
sudo apt-get -y autoremove