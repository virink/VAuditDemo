FROM php:5.6-fpm-alpine

MAINTAINER Virink <virink@outlook.com>
LABEL CHALLENGE="VAuditDemo Debug"

ADD VAuditDemo_Debug /var/www/html
ADD files /tmp/

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.tuna.tsinghua.edu.cn/g' /etc/apk/repositories \
    && apk add --update --no-cache libpng-dev nginx mysql mysql-client \
    # php mysql ext
    && docker-php-source extract \
    && docker-php-ext-install mysql gd \
    && docker-php-source delete \
    # mysql
    && mysql_install_db --user=mysql --datadir=/var/lib/mysql \
    && sh -c 'mysqld_safe &' \
    && sleep 5s \
    && mysqladmin -uroot password 'root' \
    # && mysql -e "source /tmp/db.sql;" -uroot -pqwertyuiop \
    && mkdir /run/nginx \
    # docker-php-entrypoint
    && mv /tmp/docker-php-entrypoint /usr/local/bin/docker-php-entrypoint \
    && chmod +x /usr/local/bin/docker-php-entrypoint \
    # nginx config
    && mv /tmp/nginx.conf /etc/nginx/nginx.conf \
    && mv /tmp/vhost.nginx.conf /etc/nginx/conf.d/default.conf \
    # 
    && chmod -R -w /var/www/html \
    && chmod -R 777 /var/www/html/uploads \
    && chmod -R +w /var/www/html/sys \
    && chown -R www-data:www-data /var/www/html \
    # clear
    && rm -rf /tmp/* \
    && rm -rf /etc/apk

EXPOSE 80

VOLUME ["/var/log/nginx"]

CMD ["/bin/sh", "-c", "docker-php-entrypoint"]