FROM php:7.2-apache

# Set the working directory to /var/www/html/
#WORKDIR /var/www/html/

# Install mysqli extensions
RUN docker-php-ext-install mysqli && \
apt-get update && \
apt-get install -y zlib1g-dev && \
apt-get install -y libxml2-dev && \
docker-php-ext-install zip && \
docker-php-ext-install xml

RUN a2enmod rewrite

#RUN docker-php-ext-configure mbstring
#
#RUN docker-php-ext-install mbstring

#RUN docker-php-ext-configure gd
#RUN docker-php-ext-install gd

#RUN apt-get update \
#  && apt-get install -y nano \
#  && docker-php-ext-configure mbstring mys  && docker-php-ext-install mbstring mysqli

# Copy custom apache config file
COPY src/my-apache2.conf /etc/apache2/sites-enabled/httpd.conf

COPY src/php.ini $PHP_INI_DIR/conf.d/

# Copy app files
COPY ./src/ /var/www/html/
# Copy all payu files
COPY ./payu/ /var/www/html/payu

# Install composer dependancies
#RUN cd /var/www/html/api/ && composer install

#ENV APACHE_DOCUMENT_ROOT=/var/www/html/src

#EXPOSE 8882


