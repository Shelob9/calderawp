#!/usr/bin/env bash
[ ! -e vendor ] && composer install
[  -e vendor ] && composer update
#[ ! -e node_modules ] && yarn install
# [  -e node_modules ] && yarn update

cd wp-content/plugins/caldera-mailchimp && bash install.sh
