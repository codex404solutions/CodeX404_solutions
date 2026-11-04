#!/bin/bash
# ==============================================================
#   CodeX404 Solutions - Automated Project & Database Setup
#   Project: CodeX404 Solutions CRM
# ==============================================================

set -e

if [ ! -f ".env" ] && [ -f ".env.example" ]; then
    cp ".env.example" ".env"
    echo "[i] Created default .env from .env.example"
fi

if [ -f "crm/.env.example" ] && [ ! -f "crm/.env" ]; then
    cp "crm/.env.example" "crm/.env"
fi

echo "[i] Provisioning database and executing migrations..."
php crm/database/migrate.php

echo ""
echo "=============================================================="
echo "[SUCCESS] Project and Database Setup Complete!"
echo "=============================================================="

