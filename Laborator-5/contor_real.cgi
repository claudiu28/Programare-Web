#!/usr/bin/env bash

echo "Content-type: text/html"
echo ""

n=`cat contor.txt`
n=`expr $n + 1`
echo $n > contor.txt
echo $n