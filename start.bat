@echo off
color 0B
echo.
echo ===================================================
echo     Aureum Enterprise Local Development Utility
echo ===================================================
echo.
echo [1] Start Development Server (Routine)
echo [2] FIRST TIME SETUP: Rebuild Databases from SQL Dumps
echo [3] Seed Central SuperAdmin Account
echo [4] Exit
echo.
set /p choice="Select an option (1-4): "

if "%choice%"=="2" goto setup
if "%choice%"=="3" goto seed
if "%choice%"=="4" goto :eof
goto serve

:setup
echo.
echo Installing PHP Dependencies...
call composer install --no-interaction
echo.
echo Running Automated Database Configuration...
php setup_local_env.php
echo.
echo Clearing Laravel Caches...
call php artisan optimize:clear
echo.
echo Setup Complete! Starting server...
pause
goto serve

:seed
echo.
echo Seeding SuperAdmin (superadmin@stockysaas.site / 123456)...
call php artisan db:seed --class="Database\Seeders\Central\CentralUsersSeeder" --force
echo.
pause
goto serve

:serve
echo.
echo Starting Laravel Server on http://localhost:8000
php artisan serve --port=8000
