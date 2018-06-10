#!/bin/bash

# Exit immediately if a simple command exits with a non-zero status
set -e

POSTGRESQL_BIN=/usr/lib/postgresql/9.3/bin/postgres
POSTGRESQL_CONFIG_FILE=/etc/postgresql/9.3/main/postgresql.conf
POSTGRESQL_DATA=/var/lib/postgresql/9.3/main
POSTGRESQL_SINGLE="sudo -u postgres $POSTGRESQL_BIN --single --config-file=$POSTGRESQL_CONFIG_FILE"
POSTGRESQL_INITIAL_SQL=/init.sql

# If there is no postgresql data directory, create the directory and set config data path
if [ ! -d $POSTGRESQL_DATA ]; then
    mkdir -p $POSTGRESQL_DATA
    chown -R postgres:postgres $POSTGRESQL_DATA
    sudo -u postgres /usr/lib/postgresql/9.3/bin/initdb -D $POSTGRESQL_DATA
    ln -s /etc/ssl/certs/ssl-cert-snakeoil.pem $POSTGRESQL_DATA/server.crt
    ln -s /etc/ssl/private/ssl-cert-snakeoil.key $POSTGRESQL_DATA/server.key
fi

# Setting the default password
$POSTGRESQL_SINGLE <<< "ALTER USER postgres WITH PASSWORD 'VJ30nyv3tBfPmnyKhOcU';" > /dev/null

# # Create the flag db
# $POSTGRESQL_SINGLE <<< "CREATE DATABASE sqlsanitycheck;" > /dev/null

# # Create the flag db
# $POSTGRESQL_SINGLE <<< "CREATE TABLE sqlsanitycheck.flag(flag TEXT);" > /dev/null

# sleep 10

# # Insert the flag... :^)
# $POSTGRESQL_SINGLE <<< "INSERT INTO sqlsanitycheck.flag VALUES ('tmctf{How_y0U_b3eN___1mP0rt4nT_Fl4G_f0R_h34D_Mas7eR}');" /dev/null

# Starting the postgresql server
exec sudo -u postgres $POSTGRESQL_BIN --config-file=$POSTGRESQL_CONFIG_FILE

