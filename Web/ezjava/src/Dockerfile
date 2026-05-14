FROM eclipse-temurin:8-jre-focal
LABEL Author="fb0sh <fb0sh@floatctf.com>"

COPY ezjava-1.0.0.jar /app/ezjava-1.0.0.jar
COPY flag /flag

COPY flag.sh /flag.sh
RUN chmod +x /flag.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80
WORKDIR /app

ENTRYPOINT [ "/entrypoint.sh" ]
CMD [ "java", "-jar", "/app/ezjava-1.0.0.jar", "--server.port=80" ]
