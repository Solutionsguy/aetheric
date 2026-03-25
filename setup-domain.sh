#!/bin/bash

################################################################################
# Domain Setup Script for Aetheric on Contabo Server
# Automates domain configuration, SSL setup, and Laravel configuration
################################################################################

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if running as root
if [[ $EUID -eq 0 ]]; then
   print_error "This script should NOT be run as root for safety"
   print_status "Run as regular user with sudo privileges"
   exit 1
fi

echo ""
echo "=========================================="
echo "   Aetheric Domain Setup Tool"
echo "=========================================="
echo ""

# Get domain name
read -p "Enter your domain name (e.g., aetheric.eu.org or aetheric.mooo.com): " DOMAIN_NAME

if [[ -z "$DOMAIN_NAME" ]]; then
    print_error "Domain name cannot be empty"
    exit 1
fi

# Validate domain format
if ! [[ $DOMAIN_NAME =~ ^[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(\.[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$ ]]; then
    print_error "Invalid domain name format"
    exit 1
fi

print_success "Domain name: $DOMAIN_NAME"

# Ask for www subdomain
read -p "Add www subdomain? (y/n): " ADD_WWW
ADD_WWW=${ADD_WWW:-y}

# Get server IP
print_status "Detecting server IP address..."
SERVER_IP=$(curl -s ifconfig.me)
print_success "Server IP: $SERVER_IP"

# Confirm DNS configuration
echo ""
print_warning "IMPORTANT: Before continuing, ensure your DNS is configured:"
echo "  Type: A"
echo "  Name: @"
echo "  Value: $SERVER_IP"
if [[ $ADD_WWW == "y" ]]; then
    echo "  Type: A"
    echo "  Name: www"
    echo "  Value: $SERVER_IP"
fi
echo ""
read -p "Have you configured DNS records? (y/n): " DNS_CONFIGURED

if [[ $DNS_CONFIGURED != "y" ]]; then
    print_warning "Please configure DNS records first, then run this script again"
    exit 0
fi

# Test DNS propagation
print_status "Testing DNS propagation..."
RESOLVED_IP=$(dig +short $DOMAIN_NAME @8.8.8.8 | tail -n1)

if [[ -z "$RESOLVED_IP" ]]; then
    print_warning "DNS not yet propagated. This may take up to 48 hours."
    print_warning "You can continue, but SSL setup will fail until DNS propagates."
    read -p "Continue anyway? (y/n): " CONTINUE_ANYWAY
    if [[ $CONTINUE_ANYWAY != "y" ]]; then
        exit 0
    fi
elif [[ "$RESOLVED_IP" != "$SERVER_IP" ]]; then
    print_warning "Domain resolves to $RESOLVED_IP but server IP is $SERVER_IP"
    print_warning "Please check your DNS configuration"
    read -p "Continue anyway? (y/n): " CONTINUE_ANYWAY
    if [[ $CONTINUE_ANYWAY != "y" ]]; then
        exit 0
    fi
else
    print_success "DNS correctly configured and propagated!"
fi

# Locate Laravel installation
print_status "Locating Laravel installation..."
LARAVEL_PATHS=(
    "/var/www/aetheric"
    "/var/www/html/aetheric"
    "/home/$(whoami)/aetheric"
    "$(pwd)"
)

LARAVEL_PATH=""
for path in "${LARAVEL_PATHS[@]}"; do
    if [[ -f "$path/artisan" ]]; then
        LARAVEL_PATH="$path"
        break
    fi
done

if [[ -z "$LARAVEL_PATH" ]]; then
    read -p "Enter path to Laravel installation: " LARAVEL_PATH
    if [[ ! -f "$LARAVEL_PATH/artisan" ]]; then
        print_error "Laravel installation not found at $LARAVEL_PATH"
        exit 1
    fi
fi

print_success "Laravel found at: $LARAVEL_PATH"

# Backup current configuration
print_status "Creating backup of current configuration..."
BACKUP_DIR="$LARAVEL_PATH/backups/domain-setup-$(date +%Y%m%d-%H%M%S)"
sudo mkdir -p "$BACKUP_DIR"
sudo cp "$LARAVEL_PATH/.env" "$BACKUP_DIR/.env.backup" 2>/dev/null || true
sudo cp /etc/nginx/sites-available/aetheric "$BACKUP_DIR/nginx.backup" 2>/dev/null || true
print_success "Backup created at: $BACKUP_DIR"

# Update Laravel .env file
print_status "Updating Laravel .env configuration..."
cd "$LARAVEL_PATH"

# Update APP_URL
sudo sed -i "s|^APP_URL=.*|APP_URL=https://$DOMAIN_NAME|" .env

# Update SESSION_DOMAIN
if grep -q "^SESSION_DOMAIN=" .env; then
    sudo sed -i "s|^SESSION_DOMAIN=.*|SESSION_DOMAIN=.$DOMAIN_NAME|" .env
else
    echo "SESSION_DOMAIN=.$DOMAIN_NAME" | sudo tee -a .env > /dev/null
fi

# Update SANCTUM_STATEFUL_DOMAINS
if [[ $ADD_WWW == "y" ]]; then
    SANCTUM_DOMAINS="$DOMAIN_NAME,www.$DOMAIN_NAME"
else
    SANCTUM_DOMAINS="$DOMAIN_NAME"
fi

if grep -q "^SANCTUM_STATEFUL_DOMAINS=" .env; then
    sudo sed -i "s|^SANCTUM_STATEFUL_DOMAINS=.*|SANCTUM_STATEFUL_DOMAINS=$SANCTUM_DOMAINS|" .env
else
    echo "SANCTUM_STATEFUL_DOMAINS=$SANCTUM_DOMAINS" | sudo tee -a .env > /dev/null
fi

print_success "Laravel configuration updated"

# Update Nginx configuration
print_status "Updating Nginx configuration..."

NGINX_CONFIG="/etc/nginx/sites-available/aetheric"

if [[ ! -f "$NGINX_CONFIG" ]]; then
    print_warning "Nginx config not found. Creating new configuration..."
    
    sudo tee "$NGINX_CONFIG" > /dev/null <<EOF
server {
    listen 80;
    listen [::]:80;
    server_name $DOMAIN_NAME$([ "$ADD_WWW" == "y" ] && echo " www.$DOMAIN_NAME");
    root $LARAVEL_PATH/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF
else
    # Update existing configuration
    if [[ $ADD_WWW == "y" ]]; then
        sudo sed -i "s/server_name .*/server_name $DOMAIN_NAME www.$DOMAIN_NAME;/" "$NGINX_CONFIG"
    else
        sudo sed -i "s/server_name .*/server_name $DOMAIN_NAME;/" "$NGINX_CONFIG"
    fi
fi

# Enable site if not enabled
if [[ ! -L /etc/nginx/sites-enabled/aetheric ]]; then
    sudo ln -s "$NGINX_CONFIG" /etc/nginx/sites-enabled/aetheric
    print_success "Nginx site enabled"
fi

# Test Nginx configuration
print_status "Testing Nginx configuration..."
if sudo nginx -t; then
    print_success "Nginx configuration is valid"
    sudo systemctl reload nginx
    print_success "Nginx reloaded"
else
    print_error "Nginx configuration test failed"
    print_status "Restoring backup..."
    sudo cp "$BACKUP_DIR/nginx.backup" "$NGINX_CONFIG"
    sudo nginx -t && sudo systemctl reload nginx
    exit 1
fi

# Clear Laravel cache
print_status "Clearing Laravel cache..."
cd "$LARAVEL_PATH"
sudo php artisan config:clear
sudo php artisan cache:clear
sudo php artisan route:clear
sudo php artisan view:clear
print_success "Cache cleared"

# Setup SSL with Certbot
print_status "Setting up SSL certificate with Let's Encrypt..."

# Check if certbot is installed
if ! command -v certbot &> /dev/null; then
    print_warning "Certbot not installed. Installing..."
    sudo apt update
    sudo apt install -y certbot python3-certbot-nginx
fi

# Request SSL certificate
if [[ $ADD_WWW == "y" ]]; then
    SSL_DOMAINS="-d $DOMAIN_NAME -d www.$DOMAIN_NAME"
else
    SSL_DOMAINS="-d $DOMAIN_NAME"
fi

print_status "Requesting SSL certificate..."
if sudo certbot --nginx $SSL_DOMAINS --non-interactive --agree-tos --register-unsafely-without-email --redirect; then
    print_success "SSL certificate installed successfully!"
else
    print_error "SSL certificate installation failed"
    print_warning "This is usually due to DNS not being propagated yet"
    print_warning "You can manually run: sudo certbot --nginx $SSL_DOMAINS"
fi

# Test auto-renewal
print_status "Testing SSL auto-renewal..."
sudo certbot renew --dry-run

# Final checks
echo ""
echo "=========================================="
echo "   Setup Complete!"
echo "=========================================="
echo ""
print_success "Your Aetheric application is now configured for:"
echo "  Domain: https://$DOMAIN_NAME"
if [[ $ADD_WWW == "y" ]]; then
    echo "  WWW: https://www.$DOMAIN_NAME"
fi
echo ""
print_status "Next steps:"
echo "  1. Visit https://$DOMAIN_NAME to verify"
echo "  2. Update any hardcoded URLs in database"
echo "  3. Test all functionality"
echo ""
print_warning "Database URL update (if needed):"
echo "  cd $LARAVEL_PATH"
echo "  php artisan tinker"
echo "  DB::table('settings')->where('key', 'app_url')->update(['value' => 'https://$DOMAIN_NAME']);"
echo ""

# Ask if user wants to update database
read -p "Would you like to update database URLs now? (y/n): " UPDATE_DB

if [[ $UPDATE_DB == "y" ]]; then
    print_status "Updating database URLs..."
    cd "$LARAVEL_PATH"
    php artisan tinker <<EOF
DB::table('settings')->where('key', 'app_url')->update(['value' => 'https://$DOMAIN_NAME']);
exit
EOF
    print_success "Database updated"
fi

print_success "Domain setup completed successfully!"
echo ""
echo "Test your site: https://$DOMAIN_NAME"
echo ""
