install-server: \
	ansible-playbook  $(PWD)/build/installRabbitMqServer.yml

install: install-dependencies composer

install-dependencies: \
    ansible-playbook  $(PWD)/build/installPhpDependencies.yml

composer:
	@echo docker imega/composer

	docker run --rm \
		-v $(CURDIR):/data \
		imega/composer \
		update --ignore-platform-reqs

.PHONY:install-server install composer install-dependencies
