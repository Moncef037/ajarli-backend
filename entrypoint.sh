#!/bin/bash

# Print the PORT to the Railway deployment logs so we can debug
echo "--- STARTING LARAVEL ON RAILWAY ---"
PORT=${PORT:-80}
echo "Railway assigned PORT: $PORT"

# Update Apache configuration to listen on the correct port and explicitly bind to IPv4 (0.0.0.0)
echo "Configuring Apache ports..."
sed -i "s/Listen 80/Listen 0.0.0.0:$PORT/g" /etc/apache2/ports.conf
sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf

# Disable conflicting MPMs and enable prefork
a2dismod mpm_event mpm_worker || true
a2enmod mpm_prefork

echo "Starting Apache..."
exec apache2-foreground
