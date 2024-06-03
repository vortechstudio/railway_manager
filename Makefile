PHONY: prepare

prepare:
	npm run build
	./vendor/bin/pint app/
	./vendor/bin/rector process app
	git add .
	git commit -m "style(General): Correction syntaxique du programme"
	git push origin develop


