FROM vulhub/thinkphp:5.0.23
LABEL Author="fb0sh <fb0s@outlook.com>"

COPY flag /flag
COPY flag.sh /flag.sh
RUN chmod +x /flag.sh

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh


WORKDIR /var/www/public

ENTRYPOINT [ "/entrypoint.sh" ]

CMD [ "docker-php-entrypoint", "apache2-foreground" ]
