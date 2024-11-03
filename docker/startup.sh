#!/bin/bash

handle_error() {
    echo "Erreur lors de l'exécution : $1" >&1
    exit 1
}

echo "Lancement du service Discord..." >&1
php artisan app:discord-service
if [ $? -ne 0 ]; then
    handle_error "Erreur lors du lancement du service Discord."
fi
echo "Service Discord lancé avec succès." >&1

echo "Lancement de la migration de la base de données..." >&1
php artisan migrate
if [ $? -ne 0 ]; then
    handle_error "Erreur lors de la migration de la base de données."
fi
echo "Migration terminée avec succès." >&1
# Exécuter la commande par défaut (qui est `apache2-foreground` si non surchargée)
exec "$@"
