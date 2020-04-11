#!/bin/bash
clear

PARAMETERS="$1"

echo -e "Hey, Welcome to Magrathea!\n"
echo -e "Now we are gonna install the administration system! Let's go, boy!\n\n"
sleep 1

cp Magrathea/magrathea_admin.tgz app/admin/
cd app/admin
tar xzvf magrathea_admin.tgz
rm magrathea_admin.tgz

echo -e "Everything is ok now! (it should at least)"

