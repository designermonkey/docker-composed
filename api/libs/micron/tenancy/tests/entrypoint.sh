#! /bin/bash

# wait for exteral services
while ! mysqladmin ping --host="${DATABASE_LANDLORD_HOST}" --user="${DATABASE_LANDLORD_USERNAME}" --password="${DATABASE_LANDLORD_PASSWORD}" --silent; do
    echo "Wait for database server..."
    sleep 1
done


exec "$@"
