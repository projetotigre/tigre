# --- Linux Stuff--- #
cd /var/www/tigre

# --- Backend stuff --- #

echo "--- Composer is the future. But you knew that, did you master? Nice job. ---"
composer install --dev      # instala as dependencias do backend
echo "--- All set to go! Would you like to play a game? ---"
php artisan migrate         # cria as tabelas do banco de dados

# --- Tigre stuff --- #

echo "--- Importa todos dados mapeados da base siconv ---"
# php artisan siconv:import --resource="all" #(performance issues)
php artisan siconv:import --resource="proponentes"
php artisan siconv:import --resource="areas_atuacao_proponente"
php artisan siconv:import --resource="municipios"
php artisan siconv:import --resource="naturezas_juridicas"
php artisan siconv:import --resource="empenhos" #(performance issues)

# --- Frontend packages --- #
# bower install
