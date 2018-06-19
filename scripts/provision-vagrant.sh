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
sudo apt-get install -y curl php7.1 apache2 libapache2-mod-php7.1 php7.1-curl php7.1-gd php7.1-mcrypt php7.1-readline php7.1-mbstring php7.1-bcmath zip unzip php7.1-zip mysql-server mysql-client mysql-common php7.1-mysql git-core php-xdebug


echo ">>>>>>>>> Install more locales (NL)"
sudo locale-gen nl_NL
sudo locale-gen nl_NL.UTF-8
sudo update-locale

echo "============= Configure Server ============="

echo ">>>>>>>>> xdebug"
sudo cat << EOF | sudo tee -a /etc/php/7.1/mods-available/xdebug.ini
xdebug.remote_enable=true
xdebug.remote_port=9000
xdebug.remote_host=192.168.33.1
EOF

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

# Edit the following to change the name of the database user that will be created:
APP_DB_USER=vagrant
APP_DB_PASS=postvagrantsql

# Edit the following to change the name of the database that is created (defaults to the user name)
APP_DB_NAME=app

# Edit the following to change the version of PostgreSQL that is installed
PG_VERSION=9.4

###########################################################
# Changes below this line are probably not necessary
###########################################################
print_db_usage () {
  echo "Your PostgreSQL database has been setup and can be accessed on your local machine on the forwarded port (default: 15432)"
  echo "  Host: localhost"
  echo "  Port: 16432"
  echo "  Database: $APP_DB_NAME"
  echo "  Username: $APP_DB_USER"
  echo "  Password: $APP_DB_PASS"
  echo ""
  echo "Admin access to postgres user via VM:"
  echo "  vagrant ssh"
  echo "  sudo su - postgres"
  echo ""
  echo "psql access to app database user via VM:"
  echo "  vagrant ssh"
  echo "  sudo su - postgres"
  echo "  PGUSER=$APP_DB_USER PGPASSWORD=$APP_DB_PASS psql -h localhost $APP_DB_NAME"
  echo ""
  echo "Env variable for application development:"
  echo "  DATABASE_URL=postgresql://$APP_DB_USER:$APP_DB_PASS@localhost:15432/$APP_DB_NAME"
  echo ""
  echo "Local command to access the database via psql:"
  echo "  PGUSER=$APP_DB_USER PGPASSWORD=$APP_DB_PASS psql -h localhost -p 15432 $APP_DB_NAME"
}

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

PG_REPO_APT_SOURCE=/etc/apt/sources.list.d/pgdg.list
if [ ! -f "$PG_REPO_APT_SOURCE" ]
then
  # Add PG apt repo:
  echo "deb http://apt.postgresql.org/pub/repos/apt/ trusty-pgdg main" > "$PG_REPO_APT_SOURCE"

  # Add PGDG repo key:
  wget --quiet -O - https://apt.postgresql.org/pub/repos/apt/ACCC4CF8.asc | apt-key add -
fi

# Update package list and upgrade all packages
apt-get update
apt-get -y upgrade

apt-get -y install "postgresql-$PG_VERSION" "postgresql-contrib-$PG_VERSION"

PG_CONF="/etc/postgresql/$PG_VERSION/main/postgresql.conf"
PG_HBA="/etc/postgresql/$PG_VERSION/main/pg_hba.conf"
PG_DIR="/var/lib/postgresql/$PG_VERSION/main"

# Edit postgresql.conf to change listen address to '*':
sed -i "s/#listen_addresses = 'localhost'/listen_addresses = '*'/" "$PG_CONF"

# Append to pg_hba.conf to add password auth:
echo "host    all             all             all                     md5" >> "$PG_HBA"

# Explicitly set default client_encoding
echo "client_encoding = utf8" >> "$PG_CONF"

# Restart so that all new config is loaded:
service postgresql restart

cat << EOF | su - postgres -c psql
-- Create the database user:
CREATE USER $APP_DB_USER WITH PASSWORD '$APP_DB_PASS';
-- Create the database:
CREATE DATABASE $APP_DB_NAME WITH OWNER=$APP_DB_USER
                                  LC_COLLATE='en_US.utf8'
                                  LC_CTYPE='en_US.utf8'
                                  ENCODING='UTF8'
                                  TEMPLATE=template0;
EOF

# Tag the provision time:
date > "$PROVISIONED_ON"

echo "Successfully created PostgreSQL dev virtual machine."
echo ""
print_db_usage

echo ">>>>>>>>> Cleaning up"
sudo apt-get -y autoremove