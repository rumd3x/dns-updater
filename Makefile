install:
	php composer.phar install --no-dev -o -n

env:
	@echo "PROVIDER=\"${PROVIDER}\"" >> .env
	@echo "KEY=\"${KEY}\"" >> .env
	@echo "DOMAIN=\"${DOMAIN}\"" >> .env
	@echo "RECORD=\"${RECORD}\"" >> .env
	@echo "*** ENVIRONMENT GENERATED OK ***"
