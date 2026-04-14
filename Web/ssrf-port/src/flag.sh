#!/bin/bash
# flag 动态替换脚本
sed -i "s/flag{test_flag}/$FLAG/" /var/www/4444/index.html

export FLAG=not_flag
FLAG=not_flag

rm -f /flag.sh
