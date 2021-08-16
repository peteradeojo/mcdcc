#!/bin/sh

echo "Dumping MySQL Database"
read -p "Database (maternalchild): " database
read -p "Tables to dump (all): " tables
read -p "Output file (maternalchild.sql): " output


mysqldump -u root ${database:=maternalchild} ${tables-''} > ${output:-maternalchild}.sql && echo "Database dumped successfully" || echo "Error dumping the DB"