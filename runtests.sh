#!/bin/sh

pushd tests > /dev/null
phpunit
popd > /dev/null
