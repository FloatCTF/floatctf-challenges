FROM php:5-apache-jessie
LABEL Author="fb0sh <fb0sh@outlook.com>"

COPY flag /flag
COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
COPY index.php /var/www/html/index.php
COPY meow.html /var/www/html/meow.html

RUN chmod +x /flag.sh \
    && chmod +x /entrypoint.sh

# Apache 开 4444
RUN echo "Listen 4444" >> /etc/apache2/ports.conf

# 新建 vhost
COPY 4444.conf /etc/apache2/sites-available/4444.conf

# 静态目录（替代 4444）
RUN mkdir -p /var/www/4444
COPY flag /var/www/4444/index.html

# 启用站点
RUN a2ensite 4444.conf

EXPOSE 80
# EXPOSE 4444

WORKDIR /var/www/html

ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]
