# Deploying to Railway — quick guide

1) Set Railway environment variables (in Railway dashboard -> Variables):
   - `APP_KEY` (generate locally with `php artisan key:generate --show`)
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL` (your Railway domain)
   - Database credentials (if using managed MySQL, set `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) OR use SQLite by setting `DB_CONNECTION=sqlite` and uploading a DB file if desired.
   - `SESSION_DRIVER=database` (or `file`) and other secrets (mail, midtrans keys)

2) Build assets in CI (we include a `ci-build.yml` workflow). The CI job will produce `public/build` artifacts.

3) Deploy with Railway CLI (example):

```bash
# export Railway token and project id
export RAILWAY_TOKEN="<your_token>"
export RAILWAY_PROJECT="<your_project_id>"

# locally run the helper (or call it from CI runner)
./scripts/railway-deploy.sh
```

4) After deploy, run migrations (the script runs `php artisan migrate --force`).

Notes:
- Add `RAILWAY_TOKEN` and `RAILWAY_PROJECT` as GitHub secrets if you want a workflow to deploy automatically.
- The `Procfile` provided uses `vendor/bin/heroku-php-apache2 public/` which works on many container-based PHP hosts.
