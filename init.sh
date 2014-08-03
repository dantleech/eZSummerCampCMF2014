#!/bin/bash
php app/console doctrine:database:drop --force
rm -Rf src/Acme/BasicCmsBundle
cd vendor/symfony-cmf/routing-auto && git pull origin 1.0.0-RC2 && cd -
cd vendor/symfony-cmf/routing-auto-bundle && git pull origin 1.0.0-RC2 && cd -
