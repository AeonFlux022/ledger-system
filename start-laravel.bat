@echo off
echo ================================
echo Starting Laravel Dev Environment
echo ================================

REM Go to Laravel project directory
cd /d C:\xampp\htdocs\ledger-system

REM Start Laravel server in new window
start cmd /k php artisan serve

REM Start Laravel scheduler in new window
start cmd /k php artisan schedule:work

echo Laravel server and scheduler started.
pause
