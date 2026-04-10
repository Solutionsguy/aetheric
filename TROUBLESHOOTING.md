# Emergency Troubleshooting Quick Reference

## First Action: Always Check Logs

```bash
# SSH into server first
ssh root@161.97.120.209
cd /opt/solidnew

# View all logs (most recent messages shown last)
docker compose -f docker-compose.prod.yml logs -f

# Press Ctrl+C to exit logs
```

---

## Common Symptoms & Fixes

### Symptom: "http://161.97.120.209:8085 - ERR_CONNECTION_REFUSED"

**What's happening:** Port 8085 not responding

**Fix:**
```bash
# Check if containers running
docker compose -f docker-compose.prod.yml ps

# Should show 3 containers with "Up" status
# If not, start them
docker compose -f docker-compose.prod.yml up -d

# Wait 10 seconds
sleep 10

# Try again
# curl http://localhost:8085
```

---

### Symptom: "Connection timeout" (page loads forever, doesn't connect)

**What's happening:** Nginx not responding to requests

**Fix:**
```bash
# Check nginx logs
docker compose -f docker-compose.prod.yml logs nginx

# Restart nginx
docker compose -f docker-compose.prod.yml restart nginx

# If still failing, restart all
docker compose -f docker-compose.prod.yml down
docker compose -f docker-compose.prod.yml up -d
sleep 10
```

---

### Symptom: Application loads but shows "500 Internal Server Error"

**What's happening:** PHP-FPM error or database connection issue

**Fix:**
```bash
# View app errors
docker compose -f docker-compose.prod.yml logs app

# Most likely: Database not ready
# Solution: Wait and restart app
sleep 30
docker compose -f docker-compose.prod.yml restart app

# Still failing? Check database
docker compose -f docker-compose.prod.yml logs db
```

---

### Symptom: "Database connection refused"

**What's happening:** App can't reach MySQL

**Fix:**
```bash
# Check if db container is running
docker compose -f docker-compose.prod.yml ps

# If status is "Exited", it crashed
# View db logs
docker compose -f docker-compose.prod.yml logs db

# Restart db (full restart)
docker compose -f docker-compose.prod.yml restart db

# Wait 30 seconds for MySQL to start
sleep 30

# Restart app
docker compose -f docker-compose.prod.yml restart app
```

---

### Symptom: "Port 8085 already in use"

**What's happening:** Another process using port 8085

**Fix Option A: Find and stop it**
```bash
# Find what's using port 8085
lsof -i :8085

# Kill the process
kill -9 <PID>

# Restart containers
docker compose -f docker-compose.prod.yml restart
```

**Fix Option B: Use different port**
```bash
# Edit compose file
nano docker-compose.prod.yml

# Change line:   "8085:80"  to  "8086:80"
# Save: Ctrl+X, Y, Enter

# Restart
docker compose -f docker-compose.prod.yml down
docker compose -f docker-compose.prod.yml up -d

# Access at: http://161.97.120.209:8086
```

---

### Symptom: Page loads very slow or times out after 30+ seconds

**What's happening:** Normal on first load OR database query is slow

**Fix:**
```bash
# First time is normal - PHP-FPM needs to initialize
# Wait 60 seconds and refresh

# If consistently slow:
# Check if database is healthy
docker compose -f docker-compose.prod.yml logs db

# Check app resources
docker stats

# If CPU/Memory maxed, server is overloaded
# Contact Contabo support or restart
docker compose -f docker-compose.prod.yml restart db app
```

---

### Symptom: "Permission denied" errors in logs

**What's happening:** Files not writable by www-data user

**Fix:**
```bash
# Fix permissions on storage/cache
docker compose -f docker-compose.prod.yml exec app chown -R www-data:www-data /var/www/storage
docker compose -f docker-compose.prod.yml exec app chown -R www-data:www-data /var/www/bootstrap/cache
docker compose -f docker-compose.prod.yml exec app chmod -R 775 /var/www/storage
docker compose -f docker-compose.prod.yml exec app chmod -R 775 /var/www/bootstrap/cache

# Restart app
docker compose -f docker-compose.prod.yml restart app
```

---

### Symptom: Migrations fail / database empty

**What's happening:** Migrations not run or failed

**Fix:**
```bash
# Check if database exists
docker compose -f docker-compose.prod.yml exec db mysql -u solidnew -psolidnew123 -e "USE solidnew; SHOW TABLES;"

# If empty, run migrations
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force

# If migration fails, check error
docker compose -f docker-compose.prod.yml logs app

# Last resort: Reset database
docker compose -f docker-compose.prod.yml exec db mysql -u solidnew -psolidnew123 -e "DROP DATABASE solidnew;"
docker compose -f docker-compose.prod.yml restart db
sleep 30
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
```

---

### Symptom: Can access from SSH but not from browser (Windows)

**What's happening:** Firewall blocking on server

**Fix:**
```bash
# Check if UFW firewall is active
ufw status

# If showing "active", allow port 8085
ufw allow 8085/tcp

# Verify
ufw status

# Test locally on server
curl http://localhost:8085

# Also check Contabo firewall in control panel
# https://my.contabo.com
```

---

## Nuclear Option: Full Reset

**Only do this if everything is broken**

```bash
# Stop and remove everything
docker compose -f docker-compose.prod.yml down -v

# This removes containers AND data (WARNING: data loss!)

# Rebuild from scratch
docker build -t solidnew-app:latest -f Dockerfile.prod .
docker compose -f docker-compose.prod.yml up -d

# Wait for DB to initialize
sleep 30

# Run migrations
docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
```

---

## Prevention: Monitor Regularly

```bash
# Add to crontab to check health every hour
# crontab -e

# Add this line:
# 0 * * * * cd /opt/solidnew && docker compose -f docker-compose.prod.yml ps >> /var/log/solidnew-health.log

# View health log
tail -20 /var/log/solidnew-health.log

# Expect to see "Up (healthy)" for all three containers
```

---

## One-Command Status Check

```bash
# Run this to get complete status
cd /opt/solidnew && echo "=== CONTAINERS ===" && docker compose -f docker-compose.prod.yml ps && echo -e "\n=== RESOURCES ===" && docker stats --no-stream && echo -e "\n=== RECENT LOGS ===" && docker compose -f docker-compose.prod.yml logs --tail 20
```

---

## Getting Help

When reporting issues, include:

```bash
# Capture this for support
cd /opt/solidnew
docker compose -f docker-compose.prod.yml logs > support.log 2>&1
docker stats --no-stream > resources.log
docker compose -f docker-compose.prod.yml ps > containers.log
```

Send these 3 files to your support team.

---

## Recovery Commands Cheat Sheet

```bash
cd /opt/solidnew

# Restart all (often fixes issues)
docker compose -f docker-compose.prod.yml restart

# Full restart (removes and recreates containers)
docker compose -f docker-compose.prod.yml down
docker compose -f docker-compose.prod.yml up -d

# View live logs (Ctrl+C to exit)
docker compose -f docker-compose.prod.yml logs -f

# Check health
docker compose -f docker-compose.prod.yml ps

# Rebuild image
docker build -t solidnew-app:latest -f Dockerfile.prod .
docker compose -f docker-compose.prod.yml up -d

# Clear cache
docker compose -f docker-compose.prod.yml exec app php artisan cache:clear

# View resource usage
docker stats

# Test connectivity
docker compose -f docker-compose.prod.yml exec app ping db
```

