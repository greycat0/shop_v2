FROM debian

WORKDIR /home/shop

RUN apt-get update && \
    apt-get install software-properties-common curl gnupg2 apt-transport-https ca-certificates lsb-release -y && \
    echo "deb http://nginx.org/packages/debian `lsb_release -cs` nginx" \
        | tee /etc/apt/sources.list.d/nginx.list && \
    curl -fsSL https://nginx.org/keys/nginx_signing.key | apt-key add - && \
    curl -o /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" \
        | tee /etc/apt/sources.list.d/php7.3.list && \
    curl -sL https://deb.nodesource.com/setup_12.x | bash - && \
    apt-get update && \
    apt-get install nginx php7.3-mbstring php7.3-xml php7.3-pgsql php7.3-fpm nodejs unzip -y && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --1 && \
    php -r "unlink('composer-setup.php');" && \
    sed -i "2s/.*/user www-data;/" /etc/nginx/nginx.conf && \
    sed -i "933s/.*/extension=pdo_pgsql/" /etc/php/7.3/fpm/php.ini && \
    sed -i "934s/.*/extension=pdo_sqlite/" /etc/php/7.3/fpm/php.ini && \
    sed -i "935s/.*/extension=pgsql/" /etc/php/7.3/fpm/php.ini

    
COPY src .
COPY server/.env .env

RUN php composer.phar install && npm i --only=prod && npm run prod

COPY server/shop.conf /etc/nginx/conf.d/
RUN chown -R www-data .
COPY server/wait-for-it.sh wait-for-it.sh
CMD echo hello, broo! ; service php7.3-fpm start ; ./wait-for-it.sh db:5432 -- php artisan migrate --force ; nginx -g "daemon off;"
