#!/bin/bash

echo "Backing up repo"
if [ ! -e '.backup' ]; then
    mkdir .backup
fi
cp -R .git .backup`date +%s`

function rebase
{
    BRANCH=$1
    REBASE_BRANCH=$2

    git checkout $BRANCH
    git rebase $REBASE_BRANCH
}

LAST_BRANCH=""

for BRANCH in `cat branches.list`; do
    if [[ $LAST_BRANCH  != '' ]]; then
        rebase $BRANCH $LAST_BRANCH;
    fi;

    LAST_BRANCH=$BRANCH
done;

git checkout utils
