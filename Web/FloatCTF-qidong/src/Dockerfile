FROM nginx:1.25-alpine

LABEL maintainer="FloatCTF <myx2727461997@gmail.com>"

WORKDIR /usr/share/nginx/html

COPY index.html ./
COPY result.html ./
COPY app.js ./
COPY style.css ./
EXPOSE 80

# flag替换脚本 固定， 剔除\r
COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
RUN chmod +x /flag.sh
ENTRYPOINT [ "/entrypoint.sh" ]
# flag replacer script end
# 启动 Apache 并保持前台运行
CMD [ "nginx -g 'daemon off;'" ]
