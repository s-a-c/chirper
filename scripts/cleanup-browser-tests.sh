#!/bin/bash
set -e

# Restore main tests directory and phpunit.xml
if [ -d tests.main.backup ]; then
  if [ -d tests ]; then
    rm -rf tests
  fi
  mv tests.main.backup tests
fi
if [ -f phpunit.xml.main.backup ]; then
  rm -f phpunit.xml.starter-kit-browser
  if [ -f phpunit.xml ]; then
    rm -f phpunit.xml
  fi
  mv phpunit.xml.main.backup phpunit.xml
fi
