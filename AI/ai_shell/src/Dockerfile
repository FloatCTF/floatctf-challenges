# 使用官方 Python 基础镜像
FROM python:3.10-slim

ENV OLLAMA_MODELS=/root/.ollama
# 安装依赖工具
RUN apt-get update && apt-get install -y \
    curl wget git \
    && rm -rf /var/lib/apt/lists/*

# 安装 Ollama
RUN curl -fsSL https://ollama.com/install.sh | sh


# 安装 Python 依赖
WORKDIR /app
RUN pip install  ollama
RUN pip install flask
# 拷贝你的 Python 脚本
COPY main.py /app/main.py
COPY templates /app/templates
# 暴露端口（1337 给 Telnet，11434 给 Ollama API）

RUN mkdir -p ${OLLAMA_MODELS}
COPY .ollama/* ${OLLAMA_MODELS}
COPY flag /flag
COPY flag.sh /flag.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
RUN chmod +x /flag.sh
EXPOSE 80
# 启动时同时运行 Ollama 服务 和 Python 脚本
ENTRYPOINT [ "/entrypoint.sh" ]
CMD ["ollama serve & python /app/main.py"]
