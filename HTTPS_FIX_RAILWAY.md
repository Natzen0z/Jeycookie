# HTTPS & Mixed Content Fix for Railway

## Problem
Laravel was generating HTTP URLs while Railway serves HTTPS via a load balancer, causing browser warnings: "Informasi yang akan Anda kirimkan tidak aman" (The information you will send is not secure).

## Solution Applied

### 1. Force HTTPS in Production
**File:** [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php)
- Added `URL::forceScheme('https')` to force all generated URLs to use HTTPS when `APP_ENV=production`
- This ensures all form actions, redirects, and asset URLs use `https://`

### 2. Trust Railway Proxies
**File:** [app/Http/Middleware/TrustProxies.php](app/Http/Middleware/TrustProxies.php)
- Set `$proxies = '*'` to trust all proxies from Railway's load balancers
- Configured headers to recognize X-Forwarded-* headers so Laravel knows the connection is actually HTTPS

### 3. Environment Configuration
**File:** [.env](.env)
- `APP_ENV=production` — enables production-mode security features
- `APP_DEBUG=false` — hides detailed errors in production (improves security)
- `APP_URL=https://jey-cookie.up.railway.app` — your Railway domain with HTTPS

## What This Fixes
✅ Form submissions now use HTTPS (no browser warnings)  
✅ All generated URLs and redirects use HTTPS  
✅ Laravel correctly recognizes proxied HTTPS connections  
✅ Cookies and sessions work correctly over HTTPS  

## After Deploying
1. Push these changes to GitHub
2. Railway will auto-redeploy
3. Run migrations if needed: `php artisan migrate --force`
4. Caches will be cleared by the deploy pipeline
5. Test the login form — no more "tidak aman" warnings

**Note:** Replace `jey-cookie.up.railway.app` with your actual Railway domain if different.
