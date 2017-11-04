#!/usr/bin/env bash

#
# This shell script builds the current version from the current branch
#
#
# REQUIREMENTS
#
# - jq (brew install jq)
#
#
# USAGE
#
# - Run the command: chmod +x make.sh; ./make.sh
#

# If the working copy is not clean, we cannot proceed
#if [ -n "$(git status --porcelain)" ]; then
#    red=`tput setaf 1`;
#    reset=`tput sgr0`;
#    echo "${red}There are currently uncommitted changes.";
#    echo "Please commit or stash all changes and make sure your working copy is clean.${reset}";
#    exit 1;
#fi

# Get the software name
name=($(jq -r '.extra.handle' composer.json));

# Get the software version
version=($(jq -r '.version' composer.json));

# Tell the user we're making the build directory
echo 'Making build directory...';

# Make build directory
mkdir -p localStorage/build/system/user/addons;
mkdir -p localStorage/build/themes/user;

# Tell the user we're copying things to the build directory
echo 'Copying files to the build directory...';

# Copy items to the build directory
cp -r field_limits localStorage/build/system/user/addons/;
cp -r field_limits_themes localStorage/build/themes/user/field_limits;
cp -r license.md localStorage/build/system/user/addons/field_limits/license.md;
cp -r license.md localStorage/build/license.md;
cp -r copyright.md localStorage/build/system/user/addons/field_limits/copyright.md;
cp -r copyright.md localStorage/build/copyright.md;
cp -r install.md localStorage/build/install.md;

# Tell the user we're creating the distribution file
echo 'Creating distribution zip file..';

# Change directory to the build directory
cd localStorage/build;

# Zip it all up
zip -rq ../"$name"-"$version".zip system/ themes/ license.md install.md copyright.md -x "*.DS_Store" "*.gitkeep";

# Tell the user we're deleting the build directory
echo 'Deleting build directory...';

# Change directory to localStorage root
cd ../;

# Remove the build directory
rm -r build/;

# Change directory back out to repo root
cd ../;

# Tell the user everything was successful.
echo "$name-$version.zip has been created.";
