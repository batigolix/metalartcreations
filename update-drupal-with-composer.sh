#!/usr/bin/env bash

SITES_DIR="/home/boris/Sites"
DRUSH="docker-compose exec --user 1000 php drush --root=/var/www/html"
COMPOSER="docker-compose exec --user 1000 php composer"

declare -a sites=("metalartcreations")

for i in "${sites[@]}"
do
   echo $i 
   cd $SITES_DIR/$i
   pwd
   docker-compose down
   docker-compose up -d
   git checkout master
   git stash
   $COMPOSER update
   git add composer.*
   git commit -m "update packages"
   git push origin master
   git stash pop

done

