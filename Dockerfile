FROM alpine:3.13

RUN apk --no-cache add \
php8 \
php8-fpm \
php8-pdo \
php8-mbstring \
php8-openssl

RUN apk --no-cache add \
php8-json \
php8-dom \
curl \
php8-curl

RUN apk --no-cache add \
php8-phar \
php8-xml \
php8-xmlwriter


RUN php8 -r "copy('http://getcomposer.org/installer', 'composer-setup.php');" && \
php8 composer-setup.php --install-dir=/usr/bin --filename=composer && \
php8 -r "unlink('composer-setup.php');"


COPY . /src
WORKDIR /src

CMD php -S localhost:8000 -t public

# run the php server service
# move this command to -> docker-compose.yml
# CMD php -S 0.0.0.0:8080 public/index.php