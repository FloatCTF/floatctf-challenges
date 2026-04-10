FROM vulhub/fastjson:1.2.24
LABEL Author="fb0sh <fb0s@outlook.com>"

COPY flag /flag
COPY flag.sh /flag.sh
RUN chmod +x /flag.sh

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh


WORKDIR /var/www/public

ENTRYPOINT [ "/entrypoint.sh" ]

CMD [ "java", "-Dserver.address=0.0.0.0", "-Dserver.port=8090", "-jar", "/usr/src/fastjsondemo.jar" ]
