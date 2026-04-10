#!/bin/bash

sed -i "s/flag{y0u_4re_mas7er_1n_v1ew_sourc4}/$FLAG/" /var/www/html/index.php
export FLAG=not_flag
FLAG=not_flag

rm -f /flag.sh