FROM php:5-apache-jessie
LABEL Author="ablklice <ablklice@gmail.com>"

COPY index.php /var/www/html/index.php
COPY key.php /var/www/html/key.php

COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
RUN chmod +x /flag.sh


WORKDIR /var/www/html

# 启动 Apache 并保持前台运行
ENTRYPOINT [ "/entrypoint.sh" ]
CMD [ "apache2-foreground" ]
