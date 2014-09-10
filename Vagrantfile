# -*- mode: ruby -*-
# vi: set ft=ruby :
ROOT = File.dirname(File.absolute_path(__FILE__))

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = '2'

VAGRANT_BOX = 'heyolemp-14.04-2014-09-09'
VAGRANT_BOX_URL = 'http://boxes.heyodev.com/heyolemp-14.04-2014-09-09.box'

$envscript = <<SCRIPT
sudo cp /vagrant/src/etc/vagrant.conf /etc/profile.d/vagrant.sh
sudo dos2unix /etc/profile.d/vagrant.sh
sudo chmod 644 /etc/profile.d/vagrant.sh
SCRIPT

$script = <<SCRIPT
sudo apt-get update && sudo DEBIAN_FRONTEND=noninteractive apt-get -o Dpkg::Options::='--force-confdef' -o Dpkg::Options::='--force-confold' -f -q -y upgrade
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/bin/composer
sudo chmod +x /usr/bin/composer
sudo sed -i "s/3306/$PDO_PORT/" /etc/mysql/my.cnf
sudo sed -i 's/127.0.0.1/0.0.0.0/' /etc/mysql/my.cnf
sudo sed -i 's/127.0.0.1/0.0.0.0/' /etc/redis/redis.conf
sudo sed -i 's/127.0.0.1/0.0.0.0/' /etc/couchdb/default.ini
sudo service couchdb stop
sudo service redis-server stop
sleep 1
sudo service redis-server start
sudo service couchdb start
sudo service mysql stop
sudo /usr/sbin/mysqld --skip-grant-tables --skip-networking &
sleep 2
cat > ~/mysql-init <<DELIM
FLUSH PRIVILEGES;
use mysql;
SET PASSWORD FOR root@'localhost' = PASSWORD('$PDO_PASSWORD');
UPDATE mysql.user SET Password=PASSWORD('$PDO_PASSWORD') WHERE User='root';
GRANT ALL PRIVILEGES ON *.* TO  '$PDO_USERNAME'@'%' IDENTIFIED BY '$PDO_PASSWORD' WITH GRANT OPTION;
FLUSH PRIVILEGES;
DELIM
mysqladmin -u root create $PDO_DB
dos2unix /vagrant/src/sql/struct.sql
mysql -u root $PDO_DB < /vagrant/src/sql/struct.sql
mysql -u root < ~/mysql-init
sudo killall mysqld
sudo service mysql start
rm -f ~/mysql-init
SCRIPT

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = VAGRANT_BOX
  config.vm.box_url = VAGRANT_BOX_URL

  config.vm.network "forwarded_port", guest: 3380, host: 3380, host_ip: '127.0.0.1'
  config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: '127.0.0.1'
  config.vm.network "forwarded_port", guest: 6379, host: 6379, host_ip: '127.0.0.1'
  config.vm.network "forwarded_port", guest: 5984, host: 5984, host_ip: '127.0.0.1'

  config.ssh.private_key_path = ['~/.vagrant.d/insecure_private_key', '~/.ssh/id_rsa']
  config.ssh.forward_agent = true
  
  config.vm.provision :shell, :inline => $envscript
  
  if Dir.glob("#{File.dirname(__FILE__)}/.vagrant/machines/default/*/id").empty?
    config.vm.provision :shell, :inline => $script
  end
end
