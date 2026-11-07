@echo off
setlocal

set "PROJECT_DIR=%~dp0"
for %%I in ("%PROJECT_DIR%..\..") do set "XAMPP_DIR=%%~fI"
set "STARTER=%XAMPP_DIR%\xampp_start.exe"
set "SITE_URL=http://localhost/Nhom10_TongNhutNam_TonAnhQuan_DH24TH2/Trangtin/index.php"

if not exist "%STARTER%" (
    echo Khong tim thay XAMPP tai: "%XAMPP_DIR%"
    echo Hay kiem tra lai vi tri cai dat XAMPP.
    pause
    exit /b 1
)

start "" "%STARTER%"
timeout /t 5 /nobreak >nul
start "" "%SITE_URL%"

endlocal