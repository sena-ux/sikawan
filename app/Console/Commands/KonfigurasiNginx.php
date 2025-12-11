<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class KonfigurasiNginx extends Command
{
    protected $signature = 'app:setup-sikawan';
    protected $description = 'Setup .env, APP_KEY, Nginx, Certbot, Permissions, dan PostgreSQL untuk aplikasi Sikawan';

    public function handle()
    {
        $this->info("🚀 Memulai Setup Sikawan...\n");

        /* ============================================================
         * 0. REQUIREMENT CHECK
         * ============================================================ */
        $requirements = [
            'php'      => 'PHP',
            'composer' => 'Composer',
            'psql'     => 'PostgreSQL Client (psql)',
            'nginx'    => 'Nginx',
        ];

        $this->info("🔍 Mengecek requirement...");

        $missing = false;
        foreach ($requirements as $cmd => $label) {
            if (!$this->commandExists($cmd)) {
            $this->error("❌ $label tidak ditemukan!");
            $missing = true;
            } else {
            $this->info("✔ $label ditemukan");
            }
        }

        // Check PHP-FPM version >= 8.2
        $phpFpmVersion = shell_exec("php -v | grep -oP 'PHP \K[0-9]+\.[0-9]+'");
        $phpFpmVersion = trim($phpFpmVersion);

        if ($phpFpmVersion && version_compare($phpFpmVersion, '8.2', '>=')) {
            $this->info("✔ PHP-FPM versi {$phpFpmVersion} (>= 8.2)");
        } else {
            $this->error("❌ PHP-FPM harus versi 8.2 atau lebih tinggi! (saat ini: {$phpFpmVersion})");
            $missing = true;
        }

        if ($missing) {
            $this->error("\nBeberapa requirement belum terpenuhi. Setup dibatalkan.");
            return false;
        }

        $this->info("\n✔ Semua requirement terpenuhi.\n");

        /* ============================================================
         * 0.1 KONFIRMASI
         * ============================================================ */
        if (!$this->confirm("Apakah Anda yakin ingin melanjutkan proses instalasi?", true)) {
            $this->warn("Setup dibatalkan.");
            return false;
        }

        /* ============================================================
         * 0.2 SETUP POSTGRESQL USER + DATABASE
         * ============================================================ */
        $this->info("\n🐘 Setup PostgreSQL (User & Database)");

        $pgUser = $this->ask('Nama user PostgreSQL baru', 'sikawan_user');
        $pgPass = $this->secret('Password user PostgreSQL');
        $pgDb   = $this->ask('Nama database baru', 'sikawan_db');

        $this->info("➤ Membuat user & database PostgreSQL...");

        $createSql = "
            DO \$\$
            BEGIN
            IF NOT EXISTS (SELECT FROM pg_roles WHERE rolname = '{$pgUser}') THEN
                CREATE USER {$pgUser} WITH PASSWORD '{$pgPass}';
            END IF;
            END
            \$\$;

            CREATE DATABASE {$pgDb} OWNER {$pgUser};
            GRANT ALL PRIVILEGES ON DATABASE {$pgDb} TO {$pgUser};

            \connect {$pgDb}

            GRANT ALL PRIVILEGES ON SCHEMA public TO {$pgUser};
            GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO {$pgUser};
            GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO {$pgUser};
            GRANT ALL PRIVILEGES ON ALL FUNCTIONS IN SCHEMA public TO {$pgUser};

            ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL PRIVILEGES ON TABLES TO {$pgUser};
            ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL PRIVILEGES ON SEQUENCES TO {$pgUser};
            ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL PRIVILEGES ON FUNCTIONS TO {$pgUser};
        ";

        try {
            exec("sudo -u postgres psql -c \"{$createSql}\"");
            $this->info("✔ User dan database berhasil dibuat\n");
        } catch (\Exception $e) {
            $this->error("❌ Gagal membuat user/database PostgreSQL");
        }

        /* ============================================================
         * 1. PERSIAPAN ENV
         * ============================================================ */
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            File::copy(base_path('.env.example'), $envPath);
            $this->info("📄 File .env dibuat dari .env.example");
        }

        $this->info("\n⚙️ Mengatur konfigurasi .env ...");

        $appName = $this->ask('Nama aplikasi', 'SIKAWAN');
        $appDesc = $this->ask('Deskripsi aplikasi', 'Sistem Informasi Kinerja dan Absensi Warga ASN');
        $domain  = $this->ask('Domain aplikasi (contoh: sikawan.local)', 'sikawan.local');
        $port    = $this->ask('Port aplikasi (default 80)', '80');

        $this->updateEnv([
            'APP_NAME'      => '"' . $appName . '"',
            'APP_DES'       => '"' . $appDesc . '"',
            'APP_URL'       => "http://{$domain}",
            'APP_TIMEZONE'  => 'Asia/Makassar',
            'APP_LOCALE'    => 'id',
            'APP_FAKER_LOCALE' => 'id_ID',
            'DB_CONNECTION' => 'pgsql',
            'DB_HOST'       => '127.0.0.1',
            'DB_PORT'       => '5432',
            'DB_DATABASE'   => $pgDb,
            'DB_USERNAME'   => $pgUser,
            'DB_PASSWORD'   => $pgPass,
        ]);

        $this->info("✅ .env berhasil dikonfigurasi\n");

        /* ============================================================
         * 2. APP KEY
         * ============================================================ */
        if (!env('APP_KEY')) {
            $this->info("🔑 Generate APP_KEY...");
            $this->call('key:generate');
        } else {
            $this->info("🔑 APP_KEY sudah ada");
        }

        /* ============================================================
         * 3. PHP-FPM SOCKET
         * ============================================================ */
        $this->info("\n🐘 Mengecek PHP-FPM...");
        $phpFpm = $this->detectPhpFpmSocket();

        if (!$phpFpm) {
            $this->error("❌ Tidak menemukan PHP-FPM socket!");
            return false;
        }
        $this->info("✔ PHP-FPM ditemukan: {$phpFpm}");

        /* ============================================================
         * 4. GENERATE KONFIGURASI NGINX
         * ============================================================ */
        $this->info("\n📝 Membuat konfigurasi Nginx...");

        $nginxTemplate = <<<NGINX
server {
    listen {PORT};
    server_name {DOMAIN};
    root {APP_PATH}/public;
    index index.php index.html;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass {PHP_FPM_SOCKET};
        fastcgi_hide_header X-Powered-By;
    }

    location ~* \.(jpg|jpeg|png|gif|webp|svg|css|js|ico)$ {
        expires max;
        log_not_found off;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    error_log /var/log/nginx/{DOMAIN}_error.log;
    access_log /var/log/nginx/{DOMAIN}_access.log;
}
NGINX;

        $nginxConfig = str_replace(
            ['{APP_PATH}','{DOMAIN}','{PORT}','{PHP_FPM_SOCKET}'],
            [base_path(), $domain, $port, $phpFpm],
            $nginxTemplate
        );

        $temp = storage_path("nginx_{$domain}.conf");
        File::put($temp, $nginxConfig);

        $this->info("📌 File konfigurasi berhasil dibuat:");
        $this->info("    {$temp}\n");

        $this->warn("👉 Jalankan perintah berikut:");
        $this->warn(" sudo cp {$temp} /etc/nginx/sites-available/{$domain}");
        $this->warn(" sudo ln -sf /etc/nginx/sites-available/{$domain} /etc/nginx/sites-enabled/");
        $this->warn(" sudo nginx -t && sudo systemctl restart nginx");

        /* ============================================================
         * 5. CERTBOT
         * ============================================================ */
        if ($this->confirm("\n🔐 Jalankan Certbot untuk HTTPS?", false)) {
            if ($this->commandExists('certbot')) {
                $this->warn(" sudo certbot --nginx -d {$domain}");
            } else {
                $this->error("❌ Certbot tidak ditemukan!");
            }
        }

        /* ============================================================
         * 6. PERMISSIONS
         * ============================================================ */
        $this->info("\n🔒 Mengatur permissions folder...");
        $this->setPermission('storage');
        $this->setPermission('bootstrap/cache');
        $this->setPermission('public/uploads');

        $this->info("\n✨ Setup SIKAWAN selesai!");
    }

    /* ---------------------- Helper Functions ---------------------- */

    private function updateEnv(array $data) {
        $env = base_path('.env');
        $content = File::get($env);
        foreach ($data as $key => $value) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
        }
        File::put($env, $content);
    }

    private function detectPhpFpmSocket(): ?string {
        $sockets = [
            '/run/php/php8.3-fpm.sock',
        ];
        foreach ($sockets as $sock) {
            if (file_exists($sock)) return "unix:{$sock}";
        }
        return $this->isPortOpen(9000) ? '127.0.0.1:9000' : null;
    }

    private function isPortOpen($port): bool {
        return (bool) @fsockopen('127.0.0.1', $port);
    }

    private function commandExists($cmd): bool {
        return trim(shell_exec("which {$cmd}")) !== '';
    }

    private function setPermission($path) {
        $full = base_path($path);
        if (!File::exists($full)) {
            File::makeDirectory($full, 0775, true);
        }
        chmod($full, 0775);
        $this->info(" 🔧 Permission OK: {$path}");
    }
}
