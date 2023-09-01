.PHONY: coverage
## coverage: Run tests with coverage
coverage:
	php -dxdebug.mode=coverage vendor/bin/phpunit --coverage-text --coverage-html tests/reports/
	# phpdbg -qrr vendor/bin/phpunit --coverage-html coverage

.PHONY: phpstan
## phpstan: Run phpstan
phpstan:
	./vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=1G