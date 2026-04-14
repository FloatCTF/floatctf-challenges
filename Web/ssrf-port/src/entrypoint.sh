#!/bin/bash
if [ -f /flag.sh ]; then
    echo "--- 正在初始化 Flag ---"
    sed -i 's/\r//g' /flag.sh
    /flag.sh
fi


exec "$@"
