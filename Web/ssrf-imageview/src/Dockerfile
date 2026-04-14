FROM php:5-apache-jessie
LABEL Author="fb0sh <fb0sh@outlook.com>"

COPY flag /flag
COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
COPY index.php /var/www/html/index.php
RUN chmod +x /flag.sh
RUN chmod +x /entrypoint.sh

COPY images /var/www/html/images
RUN chmod -R 777 /var/www/html/images

# 必须
EXPOSE 80
WORKDIR /var/www/html


ENTRYPOINT [ "/entrypoint.sh" ]
CMD [ "apache2-foreground" ]
