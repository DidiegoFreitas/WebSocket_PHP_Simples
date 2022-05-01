#!/bin/bash
#script de instalação e configuração
sudo apt update

#INSTALANDO PHP
sudo apt install -y php libapache2-mod-php

#INSTALANDO GIT
sudo apt-get install -y git

#Alterando a permissão do arquivo de configuração do apache
sudo chown debian:www-data /etc/apache2/sites-available/000-default.conf

#Pasta defalt do apache
cd /var/www/html

git clone https://github.com/DidiegoFreitas/WebSocket_PHP_Simples.git

cd WebSocket_PHP_Simples/
#Alterando a permissão dos arquivos do projeto
sudo chown -R debian:www-data WebSocket_PHP_Simples/



#Instalando composer

cd ~

curl -sS https://getcomposer.org/installer -o composer-setup.php

HASH=`curl -sS https://composer.github.io/installer.sig`

#Verificação
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

#Verificação 2
composer

