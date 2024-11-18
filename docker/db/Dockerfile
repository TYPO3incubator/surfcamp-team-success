FROM mariadb:10.11

COPY --chown=mysql:mysql ./data/db/db.sql /docker-entrypoint-initdb.d/db.sql
