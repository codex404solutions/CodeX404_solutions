#!/bin/bash
# ==============================================================
#   CodeX404 Solutions - Local Database Schema Sync Tool
#   Project: CodeX404 Solutions CRM
# ==============================================================

set -e

echo "[i] Syncing local MySQL schema to crm/database/schema.sql..."
php crm/database/migrate.php --export

echo ""
echo "[OK] Schema updated in repository! You can now commit and push to Git."

