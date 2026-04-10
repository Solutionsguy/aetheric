#!/bin/bash

# --- ASSET SYNC ---
echo "Syncing assets..."
cp -rn /var/www/assets/* /var/www/public/assets/

# --- SYMLINK CREATION ---
echo "Creating symlinks..."
# Remove existing directories to force symlink creation
rm -rf /var/www/public/frontend /var/www/public/backend /var/www/public/global /var/www/public/landing_theme

ln -s /var/www/public/assets/frontend /var/www/public/frontend
ln -s /var/www/public/assets/backend /var/www/public/backend
ln -s /var/www/public/assets/global /var/www/public/global
ln -s /var/www/public/assets/landing_theme /var/www/public/landing_theme

# --- RUN ORIGINAL COMMAND ---
exec "$@"
