FROM vulhub/spring-cloud-function:3.2.2
LABEL Author="fb0sh <fb0s@outlook.com>"

COPY flag /flag
COPY flag.sh /flag.sh
RUN chmod +x /flag.sh

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh


WORKDIR /tmp

ENTRYPOINT [ "/entrypoint.sh" ]
EXPOSE 8080

CMD ["java", "-Djava.security.egd=file:/dev/./urandom", "-jar", "/spring-cloud-function-sample-0.0.1-SNAPSHOT.jar" ]
