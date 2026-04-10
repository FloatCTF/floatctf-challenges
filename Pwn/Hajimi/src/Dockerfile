FROM ubuntu:22.04

# Install required packages
RUN apt-get update && apt-get install -y \
    gcc \
    xinetd \
    && rm -rf /var/lib/apt/lists/*

# Create ctf user
RUN useradd -m ctf

# Copy and compile the challenge
COPY hajimi.c /tmp/hajimi.c
RUN gcc -o /home/ctf/hajimi /tmp/hajimi.c && \
    chmod 755 /home/ctf/hajimi && \
    rm /tmp/hajimi.c

# Setup xinetd
RUN echo "service hajimi" > /etc/xinetd.d/hajimi && \
    echo "{" >> /etc/xinetd.d/hajimi && \
    echo "    disable = no" >> /etc/xinetd.d/hajimi && \
    echo "    socket_type = stream" >> /etc/xinetd.d/hajimi && \
    echo "    protocol = tcp" >> /etc/xinetd.d/hajimi && \
    echo "    wait = no" >> /etc/xinetd.d/hajimi && \
    echo "    user = ctf" >> /etc/xinetd.d/hajimi && \
    echo "    type = UNLISTED" >> /etc/xinetd.d/hajimi && \
    echo "    port = 1337" >> /etc/xinetd.d/hajimi && \
    echo "    bind = 0.0.0.0" >> /etc/xinetd.d/hajimi && \
    echo "    server = /home/ctf/hajimi" >> /etc/xinetd.d/hajimi && \
    echo "    log_type = FILE /var/log/xinetd.log" >> /etc/xinetd.d/hajimi && \
    echo "    log_on_failure = HOST" >> /etc/xinetd.d/hajimi && \
    echo "    per_source = 10" >> /etc/xinetd.d/hajimi && \
    echo "    rlimit_cpu = 20" >> /etc/xinetd.d/hajimi && \
    echo "    rlimit_as = 512M" >> /etc/xinetd.d/hajimi && \
    echo "}" >> /etc/xinetd.d/hajimi

# Copy flag script
COPY flag.sh /flag.sh
RUN chmod +x /flag.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Create initial flag file with placeholder
RUN echo "flag{test}" > /flag.txt && \
    chmod 444 /flag.txt

# Expose the service port
EXPOSE 1337
ENTRYPOINT [ "/entrypoint.sh" ]
# Run flag script and start xinetd
CMD [ "/usr/sbin/xinetd", "-dontfork" ]
