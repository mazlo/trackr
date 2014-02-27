# syncing controllers
rsync --delete -avze ssh app/routes.php app/controllers app/models app/views mindstackr.com@ssh.mindstackr.com:/www/app/
