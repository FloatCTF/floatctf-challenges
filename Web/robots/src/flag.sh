#!/bin/sh
# 替换 flag
sed -i "s/flag{test_flag}/$FLAG/g" /usr/share/nginx/html/s3cr3t_b4ckd00r.html

# 清理环境变量
export FLAG=not_flag
rm -f /flag.sh