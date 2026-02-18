# Running this Laravel project on Termux (Android)

This guide explains how to run the `2doapp` Laravel project on Termux (Android). It assumes you will clone or copy the repo into Termux and run it locally on your phone.

Important notes:
- Termux is available via F-Droid (recommended). Android WebView / Chrome won't run this — run inside the Termux terminal app.
- Some package names or availability may vary by Termux release. Commands below are the common path that works on most devices.

## 1) Install Termux and update packages

Install Termux (F-Droid recommended), open it and run:

```bash
pkg update && pkg upgrade -y
pkg install git curl wget unzip php composer nodejs sqlite
```

If `composer` is not available via `pkg`, install it manually:

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=$HOME/bin --filename=composer
php -r "unlink('composer-setup.php');"
export PATH=$HOME/bin:$PATH
```

## 2) Get the project into Termux

Clone your repo (or copy files) into a folder inside Termux home:

```bash
cd ~
git clone <your-repo-url> 2doapp
cd 2doapp
```

If you already copied the project to the phone via USB, `cd` into the project dir instead.

## 3) Prepare environment and dependencies

Copy the example env and install PHP dependencies:

```bash
cp .env.example .env
composer install --no-interaction --prefer-dist
```

Set `APP_URL` and DB settings in `.env` (edit with `nano` or `vim`):

- For local-only usage on the phone set `APP_URL=http://127.0.0.1:8000` or `http://<phone-ip>:8000` if you want to access from other devices on the same network.
- Use SQLite (easiest) by setting:

```
DB_CONNECTION=sqlite
DB_DATABASE=/data/data/com.termux/files/home/2doapp/database/database.sqlite
```

Create the SQLite file and give correct permissions:

```bash
touch database/database.sqlite
chmod 664 database/database.sqlite
```

Generate the app key and run migrations:

```bash
php artisan key:generate
php artisan migrate --force
```

If you need seeded/demo data:

```bash
php artisan db:seed
```

Ensure writable directories exist and have permissions:

```bash
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage bootstrap/cache
php artisan storage:link || true
```

## 4) Mail and logs

By default this project uses `MAIL_MAILER=log` (writes emails to `storage/logs/laravel.log`). That's convenient for local testing on the phone.

If you want real SMTP delivery, set SMTP settings in `.env` (Mailgun, Gmail SMTP, etc.).

## 5) Serve the application

To run the app and open it in the phone browser:

```bash
php artisan serve --host=0.0.0.0 --port=8000
# or
php -S 0.0.0.0:8000 -t public
```

- From the phone: open `http://127.0.0.1:8000`
- From another device on the same Wi-Fi: open `http://<phone-ip>:8000` (find phone IP with `ip addr` or `ifconfig`)

If you cannot access the phone IP due to network restrictions, use a tunneling tool such as `ngrok` to expose the local port.

## 6) Optional: exposing to the web using ngrok

1. Install or copy `ngrok` for Android (from the vendor) and authenticate it.
2. Run:

```bash
./ngrok http 8000
```

3. Ngrok will provide a public URL you can open from any device.

## 7) Troubleshooting

- Missing PHP extensions: Termux `php` package includes common extensions; if something is missing you may need to install or compile it.
- Permission errors: ensure `storage` and `bootstrap/cache` are writable by Termux user (use `chmod -R 775`).
- `APP_KEY` missing: run `php artisan key:generate`.
- No tables: run `php artisan migrate` and check `DB_CONNECTION` and `DB_DATABASE` values.
- Emails not sending: using `MAIL_MAILER=log` is easiest for local testing—check `storage/logs/laravel.log`.

## 8) Quick command summary

```bash
pkg update && pkg upgrade -y
pkg install git php composer sqlite curl unzip
cd ~/2doapp
composer install
cp .env.example .env
nano .env   # edit APP_URL, DB settings, MAIL_MAILER
touch database/database.sqlite
php artisan key:generate
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8000
```

## 9) Notes and caveats

- Performance: phones have limited CPU and RAM; large migrations or composer installs may be slow.
- Persistent background hosting: Termux can run processes in background but phones may suspend them — consider using a VPS or dedicated server for production.
- Security: do not expose debug mode publicly. Keep `.env` secrets secure.

---

If you want, I can also add a small `termux-setup.sh` script to automate these commands. Would you like that created? 
