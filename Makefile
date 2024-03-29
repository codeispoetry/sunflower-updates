up:
	docker-compose up -d && echo "port 9103"

stop:
	docker-compose stop

log-shell:
	docker-compose exec webserver sqlite3 log.db

deploy:
	rsync code/index.php code/log.php code/images.php sharepic:/var/www/sunflower-theme.de/updateserver/

images-deploy:
	make thumbnails && rsync -avh code/images/ sharepic:/var/www/sunflower-theme.de/updateserver/images/ --delete

thumbnails:
	rm code/images/thumbnails.jpg && montage -geometry 200x200+2+2 -tile 4x code/images/*.jpg code/images/thumbnails.jpg

sync-db:
	rsync sharepic:/var/www/sunflower-theme.de/updateserver/log.db code/log.db
