#!/bin/bash
# 替换 flag
sed -i "s/flag{test_flag}/$FLAG/g" /var/www/html/index.php

# 清理环境变量
export FLAG=not_flag
rm -f /flag.sh