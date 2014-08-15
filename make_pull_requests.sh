#!/bin/bash

LAST_BRANCH=""

for BRANCH in `cat branches.list`; do
    if [[ $LAST_BRANCH == "" ]]; then
        LAST_BRANCH=master
    fi

    echo "Going to PR $BRANCH onto $LAST_BRANCH"
    read

    git push origin $BRANCH
    hub pull-request -m "$BRANCH" -b $LAST_BRANCH -h $BRANCH

    LAST_BRANCH=$BRANCH
done;

git checkout utils
