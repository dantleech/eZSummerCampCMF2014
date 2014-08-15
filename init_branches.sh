#!/bin/bash

echo "Backing up repo"
if [ ! -e '.backup' ]; then
    mkdir -p .backup/.git
fi

cp -R .git .backup`date +%s`

LAST_BRANCH=""

for BRANCH in `cat branches.list`; do
    git branch -D $BRANCH
    git branch $BRANCH origin/$BRANCH
    git checkout $BRANCH
done;

git checkout utils
