phpstan:
	docker-compose run php vendor/bin/phpstan analyze

slides-build:
	docker run --rm -v $$PWD:/home/marp/app/ -e MARP_USER="$$(id -u):$$(id -g)" -e LANG=PHP marpteam/marp-cli README.md

slides-serve:
	docker run --rm --init -v $$PWD:/home/marp/app -e LANG=$LANG -e MARP_USER="$$(id -u):$$(id -g)" -p 8080:8080 -p 37717:37717 marpteam/marp-cli -s .