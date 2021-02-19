up:
	docker-compose up -d

stop:
	docker-compose stop

log-shell:
	docker-compose exec webserver sqlite3 log.db

deploy:
	rsync code/index.php code/log.php sharepic:/var/www/sunflower-theme.de/updateserver/