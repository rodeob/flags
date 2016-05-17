#!/bin/bash

set -e
set -u


################################################################################
## functions

function _usage()
{
    echo "Usage: ./tools.sh qa [command]

Available commands:
  help      Shows this text.
  all       Run commands lint, unit, cs, md, cp
  lint      PHP syntax check (lint)
  unit      unit tests & code coverage report (phpunit)
  cs        PHP coding standards (phpcs)
  cbf       PHP code beautifier and fixer (phpcbf)
  md        PHP mess detector (phpmd)
  cp        PHP copy/paste detector (phpcpd)
"
    exit
}


################################################################################
## main

# move into root directory
cd `dirname ${0}`/../..

if [ "${1:-}" != "all" ]
then
    echo "==> ${1:-}"
fi

case "${1:-}" in
    all)
        for c in lint unit cs md cp
        do
            ./tools.sh qa ${c}
        done
        ;;
    lint)
        cmd="./vendor/bin/parallel-lint --exclude vendor src tests"
        ;;
    unit)
        cmd="./vendor/bin/phpunit -c ./tests/phpunit.xml ${*:2}";
        ;;
    cs)
        cmd="./vendor/bin/phpcs --standard=PSR2 --extensions=php src tests"
        ;;
    cbf)
        cmd="./vendor/bin/phpcbf --standard=PSR2 --no-patch --extensions=php src tests"
        ;;
    md)
        cmd="./vendor/bin/phpmd src,tests text codesize,design,naming,unusedcode,controversial --strict";
        ;;
    cp)
        cmd="./vendor/bin/phpcpd --min-lines 3 --min-tokens 50 src tests";
        ;;
    *)
        _usage
        ;;
esac

if [ -n "${cmd:-}" ]
then
    # execute command
    ${cmd}
fi
