# Deployment Checklist & Quick Reference

## Pre-Deployment Checklist (Local Machine)

### Code Preparation
- [ ] All code committed to git
- [ ] `.env` file configured for production
- [ ] `APP_DEBUG=false` in `.env`
- [ ] Database credentials correct in `.env`
- [ ] `.dockerignore` file present
- [ ] No sensitive data in code/logs
- [ ] All dependencies installed (`composer install`)

### Files Ready
- [ ] `Dockerfile` present and tested
- [ ] `Dockerfile.prod` created (production version)
- [ ] `docker-compose.yml` present
- [ ] `docker-compose.prod.yml` created
- [ ] `docker/entrypoint.sh` present and executable
- [ ] `docker/nginx.conf` configured
- [ ] `storage/` and `bootstrap/cache/` directories exist

### Local Testing
- [ ] App runs locally: `docker compose up -d`
- [ ] Accessible at `http://localhost:8085`
- [ ] Database migrations work
- [ ] No errors in `docker compose logs`
- [ ] All containers healthy: `docker compose ps`

---

## Deployment Execution Checklist

### Step 1: Transfer Files
- [ ] SSH connection to 161.97.120.209 working
- [ ] Files transferred to `/opt/solidnew`
- [ ] All project files present on server
- [ ] Verify: `ssh root@161.97.120.209 "ls -la /opt/solidnew"`

### Step 2: Server Preparation
- [ ] Connected to server via SSH
- [ ] Directories created: `storage/logs bootstrap/cache docker/logs`
- [ ] Permissions set: `chmod -R 775 storage bootstrap/cache`
- [ ] Docker installed: `docker --version`
- [ ] Docker Compose installed: `docker compose --version`

### Step 3: Configuration
- [ ] `.env` file copied/created
- [ ] `.env` has correct DB credentials
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] All database variables correct

### Step 4: Build & Deploy
- [ ] Docker image built: `docker build -t solidnew-app:latest -f Dockerfile.prod .`
- [ ] Build completed without errors
- [ ] Services started: `docker compose -f docker-compose.prod.yml up -d`
- [ ] All containers running: `docker compose -f docker-compose.prod.yml ps`
- [ ] Database healthy: `docker compose -f docker-compose.prod.yml logs db`
- [ ] App healthy: `docker compose -f docker-compose.prod.yml logs app`
- [ ] Nginx healthy: `docker compose -f docker-compose.prod.yml logs nginx`

### Step 5: Database Setup
- [ ] Database migrations run (if Laravel)
- [ ] No migration errors in logs
- [ ] Data seeded (if needed)
- [ ] Database verified: `docker compose -f docker-compose.prod.yml exec db mysql -u solidnew -psolidnew123 -e "USE solidnew; SHOW TABLES;"`

### Step 6: Verification
- [ ] Application accessible: `http://161.97.120.209:8085`
- [ ] Home page loads (may take 10-30 seconds)
- [ ] No 500 errors in logs
- [ ] Firewall allows port 8085
- [ ] All critical logs checked

### Step 7: Post-Deployment
- [ ] Database backup created
- [ ] Monitoring/logging configured
- [ ] Team notified of deployment
- [ ] Rollback plan documented

---

## Common Commands Reference

### Container Management
```bash
# View all containers
docker compose -f docker-compose.prod.yml ps

# View logs
docker compose -f docker-compose.prod.yml logs -f

# Restart all
docker compose -f docker-compose.prod.yml restart

# Stop all
docker compose -f docker-compose.prod.yml down

# Start all
docker compose -f docker-compose.prod.yml up -d
```

### Database Operations
```bash
# Connect to MySQL
docker compose -f docker-compose.prod.yml exec db mysql -u solidnew -psolidnew123 solidnew

# Run migrations
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force

# Backup
docker compose -f docker-compose.prod.yml exec db mysqldump -u solidnew -psolidnew123 solidnew > backup.sql

# Restore
docker compose -f docker-compose.prod.yml exec -T db mysql -u solidnew -psolidnew123 solidnew < backup.sql
```

### Application Commands
```bash
# Clear cache
docker compose -f docker-compose.prod.yml exec app php artisan cache:clear

# Run queue
docker compose -f docker-compose.prod.yml exec app php artisan queue:work

# View app logs
docker compose -f docker-compose.prod.yml logs --tail 100 app

# SSH into app container
docker compose -f docker-compose.prod.yml exec app bash
```

### Troubleshooting
```bash
# Check port availability
lsof -i :8085

# View system resources
docker stats

# Inspect specific container
docker inspect solidnew-app

# View network
docker network inspect solidnew_solidnew-network
```

---

## Error Scenarios & Solutions

### Scenario: "Connection refused" at 161.97.120.209:8085

**Check:**
1. `docker compose -f docker-compose.prod.yml ps` - All running?
2. `docker compose -f docker-compose.prod.yml logs nginx` - Any errors?
3. `netstat -tulpn | grep 8085` - Port listening?

**Fix:**
```bash
docker compose -f docker-compose.prod.yml restart
```

### Scenario: Application returns 500 error

**Check:**
```bash
docker compose -f docker-compose.prod.yml logs app
docker compose -f docker-compose.prod.yml exec app php artisan log:tail
```

**Common causes:**
- Database not ready → `docker compose -f docker-compose.prod.yml restart db app`
- Cache issue → `docker compose -f docker-compose.prod.yml exec app php artisan cache:clear`
- Permissions → `docker compose -f docker-compose.prod.yml exec app chown -R www-data:www-data /var/www`

### Scenario: Database connection timeout

**Check:**
```bash
docker compose -f docker-compose.prod.yml logs db
docker compose -f docker-compose.prod.yml exec app ping db
```

**Fix:**
```bash
# Wait and restart
sleep 30
docker compose -f docker-compose.prod.yml restart app
```

### Scenario: Slow first load / 504 Gateway Timeout

**This is normal.** PHP-FPM needs 10-60 seconds to initialize.

**Check:**
```bash
docker compose -f docker-compose.prod.yml logs app
```

**Fix:**
- Wait 60 seconds
- Refresh browser
- Check server resources: `docker stats`

---

## After Deployment

### Essential Monitoring
```bash
# Set up log monitoring (runs in background)
docker compose -f docker-compose.prod.yml logs -f > /var/log/solidnew.log &

# Monitor resources
watch -n 5 'docker stats --no-stream'

# Check for errors periodically
docker compose -f docker-compose.prod.yml logs --tail 20 app
```

### Regular Maintenance
- Daily: Check logs for errors
- Weekly: Backup database
- Weekly: Update OS packages (`apt-get update && apt-get upgrade`)
- Monthly: Review access logs
- Quarterly: Security audit

### Update Procedure (if needed)
```bash
cd /opt/solidnew
git pull origin main
docker build -t solidnew-app:latest -f Dockerfile.prod .
docker compose -f docker-compose.prod.yml up -d
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
```

---

## Contact & Support

**IP:** 161.97.120.209  
**Port:** 8085  
**SSH User:** root  
**Project Path:** /opt/solidnew  

For issues, always start with:
```bash
cd /opt/solidnew
docker compose -f docker-compose.prod.yml logs -f
```

