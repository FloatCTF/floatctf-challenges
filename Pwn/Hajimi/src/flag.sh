#!/bin/bash

# Replace the test flag with the actual flag from environment variable
if [ -n "$FLAG" ]; then
    echo "$FLAG" > /flag.txt
    chmod 444 /flag.txt
fi

# Clear the FLAG environment variable for security
export FLAG=not_flag
unset FLAG

# Remove this script to prevent access
rm -f /flag.sh
