install-server:
	ansible-playbook  $(PWD)/build/installRabbitMqServer.yml
.PHONY:install-server
