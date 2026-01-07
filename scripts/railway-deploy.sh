#!/usr/bin/env bash
set -euo pipefail

# Simple deploy helper that builds assets and uses Railway CLI to deploy.
# Requirements:
# - npm and node installed on the runner
# - composer installed
# - environment variables: RAILWAY_TOKEN, RAILWAY_PROJECT (or set via CLI)

if [ -z "${RAILWAY_TOKEN:-}" ]; then
  echo "RAILWAY_TOKEN is not set. Export it before running this script." >&2
  exit 1
fi

if [ -z "${RAILWAY_PROJECT:-}" ]; then
  echo "RAILWAY_PROJECT is not set. Export it before running this script." >&2
  exit 1
fi

echo "Installing JS deps and building assets..."
npm ci
npm run build

echo "Installing PHP dependencies (production)..."
composer install --no-dev --optimize-autoloader

echo "Installing Railway CLI..."
npm install -g railway

echo "Logging in to Railway..."
railway login --token "$RAILWAY_TOKEN"

echo "Linking project (if not linked) and deploying..."
railway link --project "$RAILWAY_PROJECT" || true
railway up --yes || true

echo "Running remote migrations..."
railway run "php artisan migrate --force"

echo "Deploy script finished. Check Railway dashboard for logs." 
