@echo off
echo ===========================================
echo Configuration Stripe pour localhost
echo ===========================================
echo.
echo Étape 1: Installez ngrok depuis https://ngrok.com/download
echo.
echo Étape 2: Lancez cette commande dans un nouveau terminal:
echo ngrok http 80
echo.
echo Étape 3: Copiez l'URL HTTPS générée (ex: https://abc123.ngrok.io)
echo.
echo Étape 4: Modifiez includes/stripe_config.php avec:
echo - Vos vraies clés Stripe
echo - L'URL ngrok au lieu de localhost
echo.
echo Étape 5: Testez avec: php test-stripe.php
echo.
echo ===========================================
pause