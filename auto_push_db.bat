@echo off
REM === Step 1: Export MySQL FULL TABLE STRUCTURE (no data) ===
cd C:\xampp\mysql\bin

mysqldump -u root --no-data spd_hub > C:\xampp\htdocs\spd-hub\db_structure.sql

REM === Step 2: Git Auto Commit & Push ===
cd C:\xampp\htdocs\spd-hub

git add db_structure.sql
git commit -m "Auto: Update DB Structure"
git push origin main
