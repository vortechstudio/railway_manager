PHONY: prepare

prepare:
	npm run build
	./vendor/bin/pint app/
	./vendor/bin/rector process app
	git add .
	git commit -m "style(General): Correction syntaxique du programme"
	git push origin develop

review_code:
	FILES=$(shell git diff --name-only HEAD~1 HEAD)

	for file in $(FILES); do \
        review=$(shell curl -s -f -H "Content-Type: application/json" -d '{"model":"llama3", "prompt":"Peut tu me générer une review de code pour le fichier suivant: '$$file'", "stream":false}' http://82.64.133.182:11434/api/generate | jq -r '.response'); \
            if [ $$? -ne 0 ]; then \
                echo "Failed to generate review for $$file"; \
                exit 1; \
            fi; \
            echo $$review $$file >> ollama_review.txt; \
        done

	PR_NUMBER=$(shell gh pr list | head -n 1 | awk '{print $$1}')

		if [ -s ollama_review.txt ]; then \
            gh pr comment $(PR_NUMBER) --body "$$(cat ollama_review.txt)"; \
        else \
            echo "No review generated"; \
            exit 1; \
        fi


