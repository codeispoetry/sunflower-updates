up:
	docker-compose up -d

stop:
	docker-compose stop

log-shell:
	docker-compose exec webserver sqlite3 log.db