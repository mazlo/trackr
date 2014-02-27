# syncing controllers
rsync --delete -avze ssh app/routes.php app/controllers mindstackr.com@ssh.mindstackr.com:/www/app/
