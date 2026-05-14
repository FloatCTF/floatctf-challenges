FROM vulhub/flask:1.1.1
LABEL Author="fb0sh <fb0sh@outlook.com>"

COPY flag /flag
COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /flag.sh
RUN chmod +x /entrypoint.sh
RUN mkdir -p /app
COPY app.py /app/app.py
# 必须
EXPOSE 8000
WORKDIR /app


ENTRYPOINT [ "/entrypoint.sh" ]
CMD [ "/bin/sh", "-c", "gunicorn -w 4 -b :8000 -u www-data -g www-data --access-logfile - app:app" ]
