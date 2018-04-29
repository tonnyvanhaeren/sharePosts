FROM tonnyvanhaeren/php:7.2.3

RUN docker-php-ext-install mbstring pdo pdo_mysql mysqli

WORKDIR /var/www/html

ADD . /var/www/html

COPY config/php.ini /usr/local/etc/php/
COPY config/apache2.conf /etc/apache2/
COPY config/000-default.conf /etc/apache2/sites-available/

RUN a2enmod rewrite

#RUN cd /var/www/html/ && chmod 777 /images 
