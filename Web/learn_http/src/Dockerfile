FROM php:5-apache-jessie
LABEL Author="fb0sh <fb0sh@outlook.com>"

COPY index.php /var/www/html/index.php

WORKDIR /var/www/html

# flag替换脚本 固定， 剔除\r
COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
RUN chmod +x /flag.sh
ENTRYPOINT [ "/entrypoint.sh" ]
# flag replacer script end
# 启动 Apache 并保持前台运行
CMD [ "apache2-foreground" ]
