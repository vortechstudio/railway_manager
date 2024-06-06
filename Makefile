PHONY: prepare

helpers:
	php artisan ide-helper:generate
	php artisan ide-helper:models -M
	php artisan ide-helper:meta

prepare:
	npm run build
	./vendor/bin/pint app/
	./vendor/bin/rector process app
	git add .
	git commit -m "style(General): Correction syntaxique du programme"
	git push origin develop


