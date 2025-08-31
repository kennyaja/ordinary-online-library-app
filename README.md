# ordinary online library app

a web app for managing digital and physical books, made in good ol' php

flowcharts and other stuff about the structure of this app are in  `docs/`

wip


## running

to run the app: 
1. clone this repository
    ```
    git clone https://github.com/kennyaja/ordinary-online-library-app
    cd ordinary-online-library-app
    ```
2. rename `env` to `.env` (don't forget to uncomment and adjust the variables) 
3. run the command
    ```
    php -S localhost:[port] -t public/
    ```
    in the project root


## requirements

php 8.4+ (with pdo extension)
