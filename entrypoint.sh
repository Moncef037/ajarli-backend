#!/bin/bash

# Use the PORT environment variable provided by Railway, or default to 80
PORT=${PORT:-80}

# Update Apache configuration to listen on the correct port
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf

# Disable conflicting MPMs and enable prefork
a2dismod mpm_event mpm_worker || true
a2enmod mpm_prefork

# Start Apache
exec apache2-foreground
