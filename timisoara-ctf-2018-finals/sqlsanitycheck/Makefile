all: build

bash:
	bash -c "clear && docker exec -it sqlsanitycheck bash"

build:
	docker build -t sqlsanitycheck .

run:
	docker run -d -p8093:80 --name sqlsanitycheck sqlsanitycheck

run-dev:
	docker run -d -p8093:80 --name sqlsanitycheck -v ${CURDIR}/www:/app sqlsanitycheck

stop:
	docker stop sqlsanitycheck && docker rm sqlsanitycheck
