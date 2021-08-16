#!/bin/sh

echo "Hello"
echo "Beginning GIT pull request creation"
echo "------------------------------------"
sleep 2

read -p "Have you staged and committed your files? (y/n): " committed
if test "$committed" = "n"
then
  git add .
  read -p "Enter a commit message: " _message
  git commit -m "$_message"
fi

sleep 2

echo "Creating pull request"
echo "----------------------------------"
read -p "Enter repo (https://github.com/maternalchildit/mcdcc): " repo
gh pr create -R "${repo:=https://github.com/maternalchildit/mcdcc}" && exit || echo "Pull request was not created successfully"