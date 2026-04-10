FROM php:7.4-apache
LABEL Author="myx2727461997@gmail.com"

# 复制网站文件
COPY index.php /var/www/html/

WORKDIR /var/www/html

EXPOSE 80

# flag替换脚本 固定， 剔除\r
COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
RUN chmod +x /flag.sh
ENTRYPOINT [ "/entrypoint.sh" ]
# flag replacer script end
# 启动 Apache 并保持前台运行
CMD [ "apache2-foreground" ]
