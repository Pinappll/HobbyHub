#!/bin/bash

cd www/easycook-vite

npm i

npm run build

cd ../

cp .envCopy .env 

cp .envCopy ../.env

cd ../

docker-compose up -d
