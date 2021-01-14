test: phpunit code-quality

phpunit:
	./vendor/bin/phpunit
code-quality:
	./vendor/bin/psalm --show-info=true
	./vendor/bin/phpstan analyse -c phpstan.neon
docker:
	docker exec -it project_zeus_app /bin/sh