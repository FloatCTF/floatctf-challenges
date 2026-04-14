#!/bin/bash
# flag 动态替换脚本
redis-cli set flag "$FLAG"

export FLAG=not_flag
FLAG=not_flag

rm -f /flag.sh
