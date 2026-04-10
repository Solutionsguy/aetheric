# Manual Deployment Steps to Contabo Server (161.97.120.209)

## Prerequisites
- SSH client (PuTTY, PowerShell, WSL2, etc.)
- Docker & Docker Compose installed on server
- File transfer tool (WinSCP, SFTP, or SCP)

## Step-by-Step Deployment

### Step 1: Prepare Your Local Files

```powershell
# On your Windows machine
cd C:\xampp\htdocs\solidnew

# Create .dockerignore if not present
# (see DEPLOYMENT_GUIDE.md)

# Ensure all files are ready
git status
```

### Step 2: Transfer Files to Server (Choose One Method)

#### Method A: Using PowerShell SCP (Easiest)
```powershell
# On Windows PowerShell (as Administrator)
cd C:\xampp\htdocs\solidnew

# Copy entire project to server
scp -r . root@161.97.120.209:/opt/solidnew

# Note: Accept the fingerprint when prompted
```

#### Method B: Using WinSCP
1. Download WinSCP: https://winscp.net/
2. Open WinSCP
3. New Site:
   - Hostname: 161.97.120.209
   - Username: root
   - Password: [your-password]
   - Protocol: SFTP
4. Connect and navigate to `/opt`
5. Right-click → New folder → `solidnew`
6. Drag-drop all your project files into `/opt/solidnew`

#### Method C: Using Git
```powershell
cd C:\xampp\htdocs\solidnew
git add .
git commit -m "Production deployment"
git push

# On server (via SSH):
cd /opt
git clone <your-repo-url> solidnew
```

### Step 3: Connect to Your Server via SSH

```powershell
# On Windows PowerShell
ssh root@161.97.120.209

# You'll see: root@contabo-server:~#
```

### Step 4: Prepare Server Environment

```bash
# Once logged in via SSH

# Navigate to project
cd /opt/solidnew

# Create required directories
mkdir -p storage/logs bootstrap/cache docker/logs

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Verify Docker is installed
docker --version
docker compose --version

# Both should show version numbers
```

### Step 5: Configure Environment File

```bash
# Check if .env exists
cat .env

# If .env doesn't exist, copy from example
cp .env.example .env

# Edit .env with production values (use nano or vi)
nano .env

# Key settings to verify/update:
# APP_ENV=production
# APP_DEBUG=false
# DB_HOST=db
# DB_PORT=3306
# DB_DATABASE=solidnew
# DB_USERNAME=solidnew
# DB_PASSWORD=solidnew123

# Save (Ctrl+X, then Y, then Enter in nano)
```

### Step 6: Build Docker Image

```bash
cd /opt/solidnew

# Build using production Dockerfile
docker build -t solidnew-app:latest -f Dockerfile.prod .

# This takes 2-5 minutes depending on server resources
# Wait for "Successfully tagged solidnew-app:latest"
```

### Step 7: Start Services

```bash
# Start all containers in background
docker compose -f docker-compose.prod.yml up -d

# Verify all containers are running
docker compose -f docker-compose.prod.yml ps

# Expected output:
# NAME              STATUS
# solidnew-db       Up (healthy)
# solidnew-app      Up (healthy)
# solidnew-nginx    Up (healthy)
```

### Step 8: Database Initialization (First Time Only)

```bash
# Wait 10-15 seconds for MySQL to fully initialize
sleep 15

# Run Laravel migrations (if using Laravel)
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force

# Seed database (optional)
docker compose -f docker-compose.prod.yml exec app php artisan db:seed --force

# Clear cache
docker compose -f docker-compose.prod.yml exec app php artisan cache:clear
```

### Step 9: Verify Deployment

```bash
# Check all containers
docker compose -f docker-compose.prod.yml ps

# View logs (Ctrl+C to exit)
docker compose -f docker-compose.prod.yml logs -f

# Test from server
curl http://localhost:8085

# Test from your machine (PowerShell)
# curl http://161.97.120.209:8085
```

### Step 10: Allow Firewall Access (if using UFW)

```bash
# Check firewall status
ufw status

# If inactive, skip this step
# If active, allow port 8085
ufw allow 8085/tcp

# Verify
ufw status
```

### Step 11: Access Your Application

Open browser and visit:
```
http://161.97.120.209:8085
```

---

## Troubleshooting

### Issue: "Connection refused" when accessing 161.97.120.209:8085

**Solution:**
```bash
# Check if containers are running
docker compose -f docker-compose.prod.yml ps

# Check logs
docker compose -f docker-compose.prod.yml logs nginx

# Restart
docker compose -f docker-compose.prod.yml down
docker compose -f docker-compose.prod.yml up -d
```

### Issue: "Database connection failed"

**Solution:**
```bash
# Check if db container is healthy
docker compose -f docker-compose.prod.yml logs db

# Check if app can reach db
docker compose -f docker-compose.prod.yml exec app ping db

# Wait longer and restart
sleep 30
docker compose -f docker-compose.prod.yml restart app
```

### Issue: "Permission denied" on storage folder

**Solution:**
```bash
docker compose -f docker-compose.prod.yml exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker compose -f docker-compose.prod.yml exec app chmod -R 775 /var/www/storage /var/www/bootstrap/cache
```

### Issue: "Port 8085 already in use"

**Solution:**
```bash
# Find what's using port 8085
lsof -i :8085

# Kill the process
kill -9 <PID>

# Or change port in docker-compose.prod.yml
nano docker-compose.prod.yml
# Change "8085:80" to "8086:80"
```

### Issue: Slow first load (timeout)

**Solution:**
```bash
# This is normal - PHP-FPM takes time to warm up
# Wait 30-60 seconds and refresh browser

# Check logs
docker compose -f docker-compose.prod.yml logs app

# If still slow, check server resources
docker stats
```

---

## Daily Operations

### View Logs
```bash
cd /opt/solidnew

# All services
docker compose -f docker-compose.prod.yml logs -f

# Specific service (last 50 lines)
docker compose -f docker-compose.prod.yml logs --tail 50 app
docker compose -f docker-compose.prod.yml logs --tail 50 nginx
docker compose -f docker-compose.prod.yml logs --tail 50 db
```

### Restart Services
```bash
# All
docker compose -f docker-compose.prod.yml restart

# Specific service
docker compose -f docker-compose.prod.yml restart app
docker compose -f docker-compose.prod.yml restart nginx
```

### Update Code (if using Git)
```bash
cd /opt/solidnew
git pull origin main
docker compose -f docker-compose.prod.yml restart app
```

### Backup Database
```bash
docker compose -f docker-compose.prod.yml exec db mysqldump -u solidnew -psolidnew123 solidnew > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Stop Services
```bash
docker compose -f docker-compose.prod.yml down

# This stops containers but keeps data
# To also remove data: docker compose -f docker-compose.prod.yml down -v
```

---

## Final Checklist

- [ ] Files transferred to `/opt/solidnew`
- [ ] `.env` configured with correct database credentials
- [ ] Docker image built successfully
- [ ] All containers running and healthy
- [ ] Database migrations completed
- [ ] Application accessible at `http://161.97.120.209:8085`
- [ ] Logs checked for errors
- [ ] Firewall rules allow port 8085

Done! Your app is now live on your Contabo server. Let me know if you have any other questions!
