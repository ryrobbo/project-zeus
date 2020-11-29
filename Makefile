phpunit:
	./vendor/bin/phpunit
code-quality:
	./vendor/bin/psalm --show-info=true
	./vendor/bin/phpstan analyse -c phpstan.neon