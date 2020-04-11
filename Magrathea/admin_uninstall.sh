#!/bin/bash
clear

PARAMETERS="$1"

echo -e "Hey, Welcome to Magrathea!\n"
echo -e "Now we are gonna remove the administration system! I hope it was useful to you!\n\n"
sleep 1

rm -rf app/admin/magrathea_admin/

echo -e "DONE!"

