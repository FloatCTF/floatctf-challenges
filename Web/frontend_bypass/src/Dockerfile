FROM php:5-apache-jessie

LABEL Author="ablklice <ablklice@gmail.com>"

COPY ./files /tmp/
RUN cp -rf /tmp/html /var/www/ && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

# flag替换脚本 固定， 剔除\r
COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
RUN chmod +x /flag.sh
ENTRYPOINT [ "/entrypoint.sh" ]
# 启动 Apache 并保持前台运行
CMD [ "apache2-foreground" ]
