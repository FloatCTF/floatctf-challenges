FROM nginx:alpine
LABEL Author="myx2727461997@gmail.com"

# 复制网站文件
COPY index.html /usr/share/nginx/html/
COPY robots.txt /usr/share/nginx/html/
COPY s3cr3t_b4ckd00r.html /usr/share/nginx/html/
COPY nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
# flag替换脚本 固定， 剔除\r
COPY flag.sh /flag.sh
RUN chmod +x /flag.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT [ "/entrypoint.sh" ]
# flag replacer script end
# 在容器启动时执行 flag 替换，然后启动 nginx
CMD [ "nginx -g 'daemon off;'" ]
