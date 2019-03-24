install:
	php composer.phar install --no-dev -o -n

environment:
	@rm -f .env
	@echo "PROVIDER=\"${PROVIDER}\"" >> .env
	@echo "KEY=\"${KEY}\"" >> .env
	@echo "DOMAIN=\"${DOMAIN}\"" >> .env
	@echo "RECORD=\"${RECORD}\"" >> .env
	@echo "*** ENVIRONMENT GENERATED OK ***"
