phpstan:
	docker-compose run php vendor/bin/phpstan analyze

phpstan-baseline:
	docker-compose run php vendor/bin/phpstan analyze --generate-baseline

slides-build:
	docker run --rm -v $$PWD:/home/marp/app/ -e MARP_USER="$$(id -u):$$(id -g)" -e LANG=PHP marpteam/marp-cli slides/presentation.md

slides-serve:
	docker run --rm --init -v $$PWD:/home/marp/app -e LANG=$LANG -e MARP_USER="$$(id -u):$$(id -g)" -p 8080:8080 -p 37717:37717 marpteam/marp-cli -s .