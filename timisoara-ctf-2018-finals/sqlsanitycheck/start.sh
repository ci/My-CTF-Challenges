#!/bin/bash
set -m
exec supervisord -n &

# wait for postgres to start
sleep 5

# init the challenge
sudo -u postgres psql < /init.sql
echo 'task initialized successfully'

# bring back supervisor to keep docker running and happy :^)
fg
