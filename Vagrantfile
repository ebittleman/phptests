# -*- mode: ruby -*-
# vi: set ft=ruby :
ROOT = File.dirname(File.absolute_path(__FILE__))

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = '2'

VAGRANT_BOX = 'heyolemp-14.04-2014-09-09'
VAGRANT_BOX_URL = 'http://boxes.heyodev.com/heyolemp-14.04-2014-09-09.box'

$script = <<SCRIPT
sudo apt-get update && sudo DEBIAN_FRONTEND=noninteractive apt-get -o Dpkg::Options::='--force-confdef' -o Dpkg::Options::='--force-confold' -f -q -y upgrade
# sudo cp /var/www/heyo-skeleton-zf2/config/host/nginx-vhost.global /etc/nginx/sites-available/heyo-skel.conf
sudo sed -i 's/3306/3380/' /etc/mysql/my.cnf
sudo sed -i 's/127.0.0.1/0.0.0.0/' /etc/mysql/my.cnf
sudo sed -i 's/127.0.0.1/0.0.0.0/' /etc/redis/redis.conf
sudo sed -i 's/127.0.0.1/0.0.0.0/' /etc/couchdb/default.ini
# sudo dos2unix /etc/nginx/sites-available/heyo-skel.conf
# sudo rm -f /etc/nginx/sites-enabled/heyo-skel.conf
# sudo ln -s /etc/nginx/sites-available/heyo-skel.conf /etc/nginx/sites-enabled/heyo-skel.conf
# sudo service nginx stop
sudo service couchdb stop
sudo service redis-server stop
sleep 1
# sudo service nginx start
sudo service redis-server start
sudo service couchdb start
sudo service mysql stop
sudo /usr/sbin/mysqld --skip-grant-tables --skip-networking &
sleep 2
cat > ~/mysql-init <<DELIM
FLUSH PRIVILEGES;
use mysql;
SET PASSWORD FOR root@'localhost' = PASSWORD('changeme1');
UPDATE mysql.user SET Password=PASSWORD('changeme1') WHERE User='root';
GRANT ALL PRIVILEGES ON *.* TO  'root'@'%' IDENTIFIED BY 'changeme1' WITH GRANT OPTION;
FLUSH PRIVILEGES;
DELIM
mysqladmin -u root create phptests
mysql -u root < ~/mysql-init
sudo killall mysqld
sudo service mysql start
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

  config.vm.provision :shell, :inline => $script
end
