FROM php:8.2-apache-bookworm
LABEL Author="fb0sh <fb0sh@outlook.com>"

COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
COPY index.php /var/www/html/index.php
RUN chmod +x /entrypoint.sh
RUN chmod +x /flag.sh


RUN apt-get update && apt-get install -y redis-server && rm -rf /var/lib/apt/lists/*

# 必须
EXPOSE 80
WORKDIR /var/www/html


ENTRYPOINT [ "/entrypoint.sh" ]
CMD [ "apache2-foreground" ]
