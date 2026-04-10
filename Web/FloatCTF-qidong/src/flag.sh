#!/bin/sh
set -eu

FLAG_VALUE=${FLAG:-FloatCTF{example_flag}}
ESCAPED_FLAG=$(printf '%s\n' "$FLAG_VALUE" | sed -e 's/[\\/&]/\\&/g')

sed -i "s|__FLAG__|$ESCAPED_FLAG|g" /usr/share/nginx/html/result.html

export FLAG=not_flag
FLAG=not_flag

rm -f /flag.sh
