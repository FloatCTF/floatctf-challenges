FROM php:5-apache-jessie
LABEL Author="your_name <your_email@example.com>"

COPY flag /FlOtCtF_flag
COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
COPY index.php /var/www/html/index.php
RUN chmod +x /flag.sh
RUN chmod +x /entrypoint.sh

# 必须
EXPOSE 80
WORKDIR /var/www/html


ENTRYPOINT [ "/entrypoint.sh" ]
CMD [ "apache2-foreground" ]
