#!/bin/bash

DATE=`date '+%Y-%m-%d'`
REMOTE_PROJECT_DIR="/home/doesborg/public_html/metalartcreations-project"
REMOTE_SETTINGS_DIR="$REMOTE_PROJECT_DIR/settings"
REMOTE_PRODUCTION_DIR="$REMOTE_PROJECT_DIR/production"
REMOTE_STAGE_DIR="$REMOTE_PROJECT_DIR/stage"
SSH="ssh -p 7822"
HOST="doesborg@doesb.org"
SERVER_CONNECTION="$SSH $HOST"
REMOTE_COMPOSER="php -d allow_url_fopen=On /home/doesborg/composer.phar"

# prompt user for actions
echo -n "Make backup? Type y or n and [ENTER]: "
read make_backup

# backup the code and the db
if [ $make_backup =  'y' ]; then
  echo "Backing up the database"
  $SERVER_CONNECTION "cd $REMOTE_PRODUCTION_DIR/web && drush sql-dump --result-file=../../db/metalartcreations-bk-$DATE.sql"
fi

echo "Easing files and folder permissions"
$SERVER_CONNECTION "chmod 755 $REMOTE_PRODUCTION_DIR"
$SERVER_CONNECTION "find $REMOTE_PRODUCTION_DIR -type d -print0 | xargs -0 chmod 755"
$SERVER_CONNECTION "find $REMOTE_PRODUCTION_DIR -type f -print0 | xargs -0 chmod 644"
$SERVER_CONNECTION "chmod a+w $REMOTE_PRODUCTION_DIR/web/sites/default"
$SERVER_CONNECTION "chmod a+w $REMOTE_PRODUCTION_DIR/web/sites/default/settings.php"

echo "Syncing remote stage folder to remote production folder (replace the production code base)"
  $SERVER_CONNECTION "cd $REMOTE_PROJECT_DIR && rsync -az --progress --force --delete --progress --protect-args --exclude-from=deploy_exclude.txt $REMOTE_STAGE_DIR/ $REMOTE_PRODUCTION_DIR"

echo "Symlink settings and files"
$SERVER_CONNECTION "ln -sf $REMOTE_SETTINGS_DIR/production.php $REMOTE_PRODUCTION_DIR/web/sites/default/settings.local.php"
$SERVER_CONNECTION "ln -sf $REMOTE_PROJECT_DIR/files $REMOTE_PRODUCTION_DIR/web/sites/default/files"

echo "Restrict folder & file permissions"
$SERVER_CONNECTION "chmod a-w $REMOTE_PRODUCTION_DIR/web/sites/default"
$SERVER_CONNECTION "chmod a-w $REMOTE_PRODUCTION_DIR/web/sites/default/settings.php"

echo "Deploying, running db & config updates"
$SERVER_CONNECTION "cd $REMOTE_PRODUCTION_DIR/web && drush updb --y && drush cr --y && drush cim --y && drush entup --y && drush cron"

echo "Delete password protection on production"
$SERVER_CONNECTION "rm -f $REMOTE_PRODUCTION_DIR/.htaccess"


