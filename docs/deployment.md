Déploiement
===

### Spécifications

- Serveur Ubuntu 23

### Documentation

- [How to Deploy a Symfony Application](https://symfony.com/doc/current/deployment.html)
- [Configuring a Web Server](https://symfony.com/doc/current/setup/web_server_configuration.html)

### Procédure

```shell
sudo su
apt-get update && apt-get upgrade
```

**PHP**

```shell
apt-get install php8.1-fpm \
    php8.1-cli \
    php8.1-mysql \
    php8.1-curl \
    php8.1-gd \
    php8.1-opcache \
    php8.1-phpdbg \
    php8.1-xml \
    php8.1-zip \
    php8.1-intl \
    php8.1-xmlrpc \
    php8.1-soap \
    php8.1-mbstring \
    php-memcached \
    unzip

php --version
```

Composer :

```shell
cd ~
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
HASH=`curl -sS https://composer.github.io/installer.sig`
echo $HASH
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

**MariaDB**

```shell
apt-get install mariadb-server
mysql_secure_installation
mysql -uroot -p
```

Création d'un utilisateur :

```sql
CREATE USER 'symfony'@'localhost' IDENTIFIED BY '****';
GRANT ALL ON *.* TO symfony@localhost;
FLUSH PRIVILEGES;
```

Récupération des sources de l'application :

```shell
cd /var/www
git clone https://github.com/Xora123/Symfony-SP
chown -R www-data:www-data Symfony-SP
cd Symfony-SP
```

Création de la base de données :

```shell
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:validate
```

**Postfix**

```shell
apt-get install postfix
```

**NGINX**

```shell
apt-get install nginx
vi /etc/nginx/sites-enabled/symfony.conf
```

```conf
server {
    server_name _;
    root /var/www/Symfony-SP/public;
    index index.php;

    location / {
        # try to serve file directly, fallback to index.php
        try_files $uri /index.php$is_args$args;
    }

    location ~ \.php {
        try_files $uri /index.php =404;
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param SCRIPT_NAME $fastcgi_script_name;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_index index.php;
        include fastcgi_params;
    }

    # return 404 for all other php files not matching the front controller
    # this prevents access to other php files you don't want to be accessible.
    location ~ \.php$ {
        return 404;
    }
}
```

```shell
ln -s /etc/nginx/sites-enabled/symfony.conf /etc/nginx/sites-available/symfony.conf
service nginx restart
```
