# 🚀 START HERE - Deploy Aetheric to Contabo Servers

Welcome! This guide helps you deploy **Aetheric** (Laravel application) to your **Contabo VPS/Dedicated Server**.

---

## 📚 Documentation Overview

I've created a complete deployment package with **6 key files**:

### 1️⃣ **FREE_DOMAIN_SETUP_GUIDE.md** ⭐ READ THIS FIRST
- 8+ free domain providers compared
- Step-by-step DNS configuration
- Recommended: **EU.ORG** (best free domain)
- Quick options: **Afraid.org**, **DuckDNS** (instant)

### 2️⃣ **CONTABO_QUICKSTART.md**
- Fast deployment in ~30 minutes
- One-command server setup
- Perfect for beginners

### 3️⃣ **CONTABO_DEPLOYMENT_GUIDE.md**
- Complete reference documentation
- Manual step-by-step instructions
- Advanced configurations

### 4️⃣ **setup-domain.sh** (Automated Script)
- Configures your free domain automatically
- Sets up SSL certificate (Let's Encrypt)
- Updates Laravel configuration
- Updates Nginx configuration

### 5️⃣ **contabo-server-setup.sh**
- Full server configuration script
- Installs PHP 8.3, MySQL, Nginx, Redis
- Hardens security automatically
- Sets up firewall

### 6️⃣ **CONTABO_TROUBLESHOOTING.md**
- Solutions for common issues
- Performance optimization
- Security tips

---

## 🎯 Quick Start (3 Steps)

### **Step 1: Get a Free Domain** (5-10 minutes)

Choose one:

**Option A - Fastest (5 minutes):**
```
1. Go to https://freedns.afraid.org
2. Sign up free
3. Choose subdomain: yourname.mooo.com
4. Point to your Contabo IP
```

**Option B - Best (7-14 days wait):**
```
1. Go to https://nic.eu.org
2. Register: yourname.eu.org
3. Wait for approval (use Option A meanwhile)
```

### **Step 2: Setup Your Contabo Server** (20 minutes)

SSH into your Contabo server:
```bash
ssh root@your-contabo-ip
```

Download and run the automated setup:
```bash
# Clone or upload this project to your server
cd /root
git clone <your-repo-url> aetheric
cd aetheric

# Run automated server setup
chmod +x contabo-server-setup.sh
sudo ./contabo-server-setup.sh
```

### **Step 3: Configure Your Domain** (5 minutes)

```bash
# Run domain setup script
chmod +x setup-domain.sh
./setup-domain.sh

# Follow the prompts:
# - Enter your domain (e.g., yourname.mooo.com)
# - Script will configure everything automatically
# - SSL certificate installed automatically
```

**Done!** Visit `https://yourdomain.com` 🎉

---

## 📋 Detailed Workflow

### For Complete Beginners:

1. **Read**: `FREE_DOMAIN_SETUP_GUIDE.md` (10 min)
2. **Get Domain**: Register at Afraid.org or EU.ORG (5-10 min)
3. **Read**: `CONTABO_QUICKSTART.md` (5 min)
4. **Deploy**: Run `contabo-server-setup.sh` (20 min)
5. **Configure**: Run `setup-domain.sh` (5 min)
6. **Test**: Visit your domain

### For Experienced Users:

1. Get free domain from `FREE_DOMAIN_SETUP_GUIDE.md`
2. Run `contabo-server-setup.sh` on fresh Contabo server
3. Run `setup-domain.sh` to configure domain
4. Reference `CONTABO_DEPLOYMENT_GUIDE.md` for customization

---

## 🆓 Free Domain Quick Comparison

| Provider | Domain Example | Setup Time | Best For |
|----------|---------------|------------|----------|
| **Afraid.org** | yourname.mooo.com | 5 minutes | Testing, quick start |
| **EU.ORG** | yourname.eu.org | 7-14 days | Production, professional |
| **DuckDNS** | yourname.duckdns.org | 5 minutes | Simple projects |
| **Cloudflare** | yourname.workers.dev | 10 minutes | CDN + DDoS protection |

**My Recommendation**: Register **EU.ORG** now (for future), use **Afraid.org** today (instant).

---

## ✅ What These Scripts Do

### **contabo-server-setup.sh** handles:
- ✅ Updates system packages
- ✅ Installs PHP 8.3 + extensions
- ✅ Installs MySQL 8.0
- ✅ Installs Nginx web server
- ✅ Installs Redis cache
- ✅ Installs Composer
- ✅ Configures firewall (UFW)
- ✅ Hardens security
- ✅ Installs SSL tools (Certbot)
- ✅ Creates deployment user
- ✅ Sets proper permissions

### **setup-domain.sh** handles:
- ✅ Validates DNS configuration
- ✅ Updates Laravel `.env` file
- ✅ Configures Nginx for your domain
- ✅ Installs FREE SSL certificate
- ✅ Sets up auto-renewal
- ✅ Clears Laravel cache
- ✅ Tests configuration

---

## 🔒 Security Features Included

- ✅ Firewall configured (ports 22, 80, 443 only)
- ✅ SSH hardening
- ✅ Fail2ban for brute-force protection
- ✅ Free SSL certificate (Let's Encrypt)
- ✅ Automatic security updates
- ✅ PHP security settings optimized
- ✅ MySQL secured
- ✅ Proper file permissions

---

## 💰 Cost Breakdown

### What's FREE:
- ✅ Domain (EU.ORG, Afraid.org, etc.)
- ✅ SSL Certificate (Let's Encrypt)
- ✅ All software (Linux, Nginx, PHP, MySQL)
- ✅ These deployment scripts

### What You Pay For:
- 💵 Contabo VPS: €4.50-6.50/month (~$5-7/month)

**Total monthly cost: ~$5-7 only** 🎉

---

## 🆘 Need Help?

1. **Common Issues**: Check `CONTABO_TROUBLESHOOTING.md`
2. **DNS Problems**: See `FREE_DOMAIN_SETUP_GUIDE.md` → DNS Configuration
3. **Server Issues**: Check `CONTABO_DEPLOYMENT_GUIDE.md` → Troubleshooting

---

## 🎯 Your Action Plan

**Right Now:**
1. ⬜ Read `FREE_DOMAIN_SETUP_GUIDE.md`
2. ⬜ Choose and register a free domain
3. ⬜ Configure DNS to point to Contabo IP

**Next (while DNS propagates):**
1. ⬜ SSH into Contabo server
2. ⬜ Upload/clone this project
3. ⬜ Run `contabo-server-setup.sh`

**Finally:**
1. ⬜ Run `setup-domain.sh`
2. ⬜ Visit your domain
3. ⬜ Configure Aetheric application

---

## 📞 Quick Commands Reference

```bash
# Get your server IP
curl ifconfig.me

# Run server setup
sudo ./contabo-server-setup.sh

# Run domain setup
./setup-domain.sh

# Check Nginx status
sudo systemctl status nginx

# Check SSL certificate
sudo certbot certificates

# View logs
sudo tail -f /var/log/nginx/error.log
```

---

## 🎉 Expected Timeline

- **Get Free Domain**: 5 minutes (or 7-14 days for EU.ORG)
- **DNS Propagation**: 5 minutes to 48 hours
- **Server Setup**: 20-30 minutes
- **Domain Configuration**: 5 minutes
- **Testing**: 10 minutes

**Total active time: ~40-50 minutes**

---

## 🌟 Pro Tips

1. **Register EU.ORG now** even if using Afraid.org temporarily
2. **Save backups** before making changes
3. **Use strong passwords** for MySQL and admin accounts
4. **Enable 2FA** on Contabo control panel
5. **Monitor server resources** via Contabo dashboard

---

**Ready to start?** Open `FREE_DOMAIN_SETUP_GUIDE.md` now! 🚀
