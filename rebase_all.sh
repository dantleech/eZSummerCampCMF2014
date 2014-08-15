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

    echo "Rebasing $BRANCH onto $REBASE_BRANCH"
    read

    git checkout $BRANCH
    LAST_HASH=`git log -n1 --pretty="%H"`
    git reset --hard $REBASE_BRANCH
    git cherry-pick $LAST_HASH

    if [[ $? != 0 ]]; then
        echo "FAIL"
        git checkout utils
        exit 1
    fi
}

LAST_BRANCH=""

for BRANCH in `cat branches.list`; do
    if [[ $LAST_BRANCH  != '' ]]; then
        rebase $BRANCH $LAST_BRANCH;
    fi;

    LAST_BRANCH=$BRANCH
done;

git checkout utils
