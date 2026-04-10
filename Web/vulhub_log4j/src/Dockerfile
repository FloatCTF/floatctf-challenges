FROM vulhub/solr:8.11.0
LABEL Author="fb0sh <fb0s@outlook.com>"

COPY flag /flag
COPY flag.sh /flag.sh
RUN chmod +x /flag.sh

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh


WORKDIR /var/www/public

ENTRYPOINT [ "/entrypoint.sh" ]
EXPOSE 8983
CMD [ "solr", "-f", "-force", "-p", "8983", "-a", "-agentlib:jdwp=transport=dt_socket,server=y,suspend=n,address=5005" ]
