install:
	php composer.phar install --no-dev -o -n

entrypoint:
	rm -f .env
	rm -f app.log
	touch app.log
	@echo "PROVIDER=\"${PROVIDER}\"" >> .env
	@echo "KEY=\"${KEY}\"" >> .env
	@echo "DOMAIN=\"${DOMAIN}\"" >> .env
	@echo "RECORD=\"${RECORD}\"" >> .env
	@echo "*** ENVIRONMENT GENERATED OK ***"
	@cron
	@tail -f app.log
