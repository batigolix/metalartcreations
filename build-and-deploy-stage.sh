#!/bin/bash

DATE=`date '+%Y-%m-%d'`
REASON="Deployment stopped because"
# LOCAL_DIR="/home/boris/Sites/metalartcreations-build"

REMOTE_PROJECT_DIR="/home/doesborg/public_html/metalartcreations-project"

# REMOTE_TEMP_DIR="$REMOTE_PROJECT_DIR/temp"
REMOTE_SETTINGS_DIR="$REMOTE_PROJECT_DIR/settings"
REMOTE_STAGE_DIR="$REMOTE_PROJECT_DIR/stage"
SSH="ssh -p 7822"
HOST="doesborg@doesb.org"
SERVER_CONNECTION="$SSH $HOST"
REMOTE_COMPOSER="php -d allow_url_fopen=On /home/doesborg/composer.phar"

function show_help {
  echo "$0 -s <site> [-fd]"
  echo " options:"
  echo " -t provide a tag e.g. ./deploy.sh -t v1.2"
}

while getopts "h?t:" opt; do
  case "$opt" in
  h|\?)
    show_help
    exit 1
    ;;
  t)  TAG=$OPTARG
    ;;
  esac
done

if [ "$TAG" = '' ] ; then
	show_help
	exit 1
fi

echo $TAG

echo "Write tag to file"
$SERVER_CONNECTION "echo $TAG > $REMOTE_STAGE_DIR/web/.deployed_tag"

echo "Easing files & folder permissions"
$SERVER_CONNECTION "chmod a+w $REMOTE_STAGE_DIR/web/sites/default"
$SERVER_CONNECTION "chmod a+w $REMOTE_STAGE_DIR/web/sites/default/settings.php"

echo "Building"
$SERVER_CONNECTION "cd $REMOTE_STAGE_DIR && git fetch --tags && git checkout -f $TAG"
#$SERVER_CONNECTION "cd $REMOTE_STAGE_DIR && $REMOTE_COMPOSER clearcache"
$SERVER_CONNECTION "cd $REMOTE_STAGE_DIR && $REMOTE_COMPOSER install --no-dev --ignore-platform-reqs"

echo "Symlink settings and files"
$SERVER_CONNECTION "ln -sf $REMOTE_SETTINGS_DIR/stage.php $REMOTE_STAGE_DIR/web/sites/default/settings.local.php"
$SERVER_CONNECTION "ln -sf $REMOTE_PROJECT_DIR/files $REMOTE_STAGE_DIR/web/sites/default/files"

echo "Deploying, running db & config updates"
$SERVER_CONNECTION "cd $REMOTE_STAGE_DIR/web && drush updb --y && drush cr --y && drush cim --y && drush entup --y && drush cron"

echo "Restrict folder & file permissions"
$SERVER_CONNECTION "chmod a-w $REMOTE_STAGE_DIR/web/sites/default"
$SERVER_CONNECTION "chmod a-w $REMOTE_STAGE_DIR/web/sites/default/settings.php"
