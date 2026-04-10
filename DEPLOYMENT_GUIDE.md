# Deployment Guide: Solidnew to Contabo Linux Server

## Server Details
- **IP:** 161.97.120.209
- **Port:** 8085
- **OS:** Linux
- **Runtime:** Docker & Docker Compose
- **PHP:** 8.4-fpm
- **Web Server:** Nginx
- **Database:** MySQL 8.0

## Prerequisites
1. SSH access to 161.97.120.209
2. Docker and Docker Compose installed on the server
3. Git installed (optional, for version control)

## Step 1: Prepare Your Local Project

### 1.1 Create a .dockerignore file
```
.git
.gitignore
node_modules
.env.local
.env.*.local
tests/
README.md
docker-compose.override.yml
.vscode
.idea
```

### 1.2 Optimize your .env for production
Before transferring, create a `docker/.env.production` file with production values:
```
APP_ENV=production
APP_DEBUG=false
DB_HOST=db
DB_PORT=3306
DB_DATABASE=solidnew
DB_USERNAME=solidnew
DB_PASSWORD=solidnew123
CACHE_DRIVER=file
SESSION_DRIVER=file
```

## Step 2: Transfer Files to Server

### Option A: Using Git (Recommended)
```bash
# On your local machine, commit your changes
cd C:\xampp\htdocs\solidnew
git add .
git commit -m "Ready for production deployment"
git push origin main

# On the Contabo server
ssh root@161.97.120.209
cd /opt
git clone <your-repo-url> solidnew
cd solidnew
```

### Option B: Using SCP (No Git)
```bash
# On your local machine (PowerShell)
scp -r C:\xampp\htdocs\solidnew root@161.97.120.209:/opt/solidnew
```

### Option C: Manual Upload
1. Create a ZIP: Right-click project folder → Send to → Compressed folder
2. Upload via SFTP (WinSCP, Filezilla, etc.) to `/opt/solidnew`
3. SSH into server and extract: `unzip solidnew.zip`

## Step 3: SSH into Your Server

```bash
ssh root@161.97.120.209
```

## Step 4: Set Up the Server Environment

```bash
# Navigate to project
cd /opt/solidnew

# Create required directories
mkdir -p storage/logs bootstrap/cache
mkdir -p docker/logs

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Create .env from example (if needed)
cp .env.example .env
# Or use the one you transferred

# Update permissions for .env
chmod 600 .env
```

## Step 5: Build and Start Containers

```bash
# Build the PHP image
docker build -t solidnew-app:latest .

# Start services
docker compose up -d

# Verify all containers are running
docker ps

# Check logs
docker compose logs -f
```

## Step 6: Database Setup (First Time)

```bash
# Wait 10 seconds for MySQL to be ready
sleep 10

# Run Laravel migrations (if applicable)
docker compose exec app php artisan migrate --force

# Optional: Seed the database
docker compose exec app php artisan db:seed --force
```

## Step 7: Verify Deployment

```bash
# Test from server
curl http://localhost:8085
curl http://161.97.120.209:8085

# Check container health
docker compose ps

# View app logs
docker compose logs app

# View nginx logs
docker compose logs nginx
```

## Step 8: Configure Firewall (if needed)

```bash
# Allow port 8085
ufw allow 8085/tcp

# Verify
ufw status
```

## Common Issues & Solutions

### Issue: Port 8085 Already in Use
```bash
# Find and kill the process
lsof -i :8085
kill -9 <PID>

# Or change port in docker-compose.yml
# Change "8085:80" to "8086:80"
```

### Issue: Database Connection Failed
```bash
# Check if db container is running
docker compose ps

# View db logs
docker compose logs db

# Verify network connectivity
docker compose exec app ping db
```

### Issue: Permission Denied on Storage/Bootstrap
```bash
# Fix permissions
docker compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker compose exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

### Issue: Slow First Load / Timeout
- Wait 30-60 seconds for PHP-FPM to warm up
- Check: `docker compose logs app`
- Ensure database is ready: `docker compose logs db`

## Maintenance Commands

### View Logs
```bash
# All containers
docker compose logs -f

# Specific container
docker compose logs -f app
docker compose logs -f nginx
docker compose logs -f db
```

### Update Code (if using git)
```bash
cd /opt/solidnew
git pull origin main
docker compose restart app
```

### Restart Services
```bash
# Restart all
docker compose restart

# Restart specific service
docker compose restart app
```

### Backup Database
```bash
docker compose exec db mysqldump -u solidnew -psolidnew123 solidnew > backup.sql
```

### Restore Database
```bash
docker compose exec -T db mysql -u solidnew -psolidnew123 solidnew < backup.sql
```

## Production Checklist

- [ ] `.env` configured with production values
- [ ] `APP_DEBUG=false` in `.env`
- [ ] Database backups automated
- [ ] SSL/TLS certificate configured (optional, via reverse proxy)
- [ ] All containers passing health checks
- [ ] Firewall rules set for port 8085
- [ ] Monitor logs regularly: `docker compose logs -f`
- [ ] Set up monitoring/alerting

## Access Your Application

Once deployed and running:
```
http://161.97.120.209:8085
```

## Support

If you encounter issues:
1. Check logs: `docker compose logs -f`
2. Verify containers: `docker compose ps`
3. Test connectivity: `curl http://localhost:8085`
4. Check server resources: `docker stats`
