Yet Another PHP Sandbox
=======================

Structural ideas:
- tmp/ folder -w- perm
- filter {\w3,}
- php disable_functions everything except putenv, mail
- first task, sandbox filter bypass to get `file('./flag.php')`
- second task, use ChankRO, LD_PRELOAD to get RCE, execute `./get_flag`

# Task 1
I've created a small sandbox for you, can you read `./flag.php`?

# Task 2
The sandbox goes one level deeper and requires you to execute `/get_flag` to get the second flag. Are you up for the challenge?

# To run using docker:
Build first using:
`docker build -t yaps .`

Then
`docker run -p8019:80 -d yaps`

For development purposes, can run:
`docker run -p8019:80 -v $(pwd)/www:/var/www/site -d yaps`
