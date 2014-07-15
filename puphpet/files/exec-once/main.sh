# --- Linux Stuff--- #
cd /var/www/tigre
chmod -R o+w app/storage/
echo "export APP_ENV=local" /etc/environment

composer install --dev
