install-server:
	ansible-playbook  $(PWD)/build/installRabbitMqServer.yml

install: composer

composer:
	@echo docker imega/composer

	docker run --rm \
		-v $(CURDIR):/data \
		imega/composer \
		update --ignore-platform-reqs

.PHONY:install-server install composer
