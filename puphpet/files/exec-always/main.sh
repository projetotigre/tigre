# --- Linux Stuff--- #
cd /var/www/tigre

# --- Laravel stuff here --- #
php artisan migrate # migra o banco de dados
php artisan db:seed # insere dados fake no banco

# --- Load Bower packages --- #
# bower install