# PHP-REvival

## Reversing PHP opcodes, find satisfiable solution (using z3 maybe), md5 magic collision
## medium

# To run:
Build first using:
`docker build -t phprevival .`

Then
`docker run -p8018:80 -d phprevival`

For development purposes, can run:
`docker run -p8018:80 -v $(pwd)/www:/var/www/site -d phprevival`
