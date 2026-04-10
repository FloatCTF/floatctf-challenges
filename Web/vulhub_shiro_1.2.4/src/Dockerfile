FROM vulhub/shiro:1.2.4
LABEL Author="fb0sh <fb0s@outlook.com>"

COPY flag /flag
COPY flag.sh /flag.sh
RUN chmod +x /flag.sh

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh


WORKDIR /var/www/public

ENTRYPOINT [ "/entrypoint.sh" ]

CMD ["java", "-jar", "/shirodemo-1.0-SNAPSHOT.jar"]
