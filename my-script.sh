#!/bin/sh
echo Hello world
echo ----------------------
echo Beginning git integration sir

git add .

echo Enter git commit message
read commit

git commit -m "$commit" && echo Commit successfull || echo Commit failed