# MBC Landing Page
Landing page untuk MBCLab yang dibangun dengan Nginx, PHP, dan terhubung ke backend CSCLI serta dashboard keamanan (Wazuh & CrowdSec). Mendukung pengiriman email via PHPMailer dan telah dilengkapi dengan SSL dari Let's Encrypt dari Certbot.
## 🧾 Struktur Proyek
```text
/mbc-landing-page
├── /assets           		# Berisi gambar dan media statis
├── /css              		# File CSS (jika ada di luar Tailwind)
├── /vendor           		# Dependensi dari Composer (terutama PHPMailer)
├── Big-Data.html     		# Halaman divisi Big Data
├── composer.json     		# File konfigurasi Composer
├── contact.html      		# Formulir kontak (frontend)
├── Cybersecurity.html		# Halaman divisi Cybersecurity
├── developer.html    		# Halaman divisi Developer
├── Game-Tech.html    		# Halaman divisi Game Technology
├── GIS.html          		# Halaman divisi GIS
├── index.html        		# Halaman utama landing page
├── send-message.php  		# Backend untuk mengirim email via PHPMailer
├── tailwind.config.js		# Konfigurasi Tailwind CSS
```


# 🚀 Instalasi Lokal & Deployment
1. **Clone Repo**
```bash
git clone https://github.com/FirdausYudha/mbc-landing-page.git
cd mbc-landing-page
```
2. **Instalasi dependensi**
```bash
composer install
```
3. **Pastikan PHP dan PHP-FPM berjalan (Contoh: PHP 8.1)**
```bash
sudo apt install php8.1 php8.1-fpm
sudo systemctl start php8.1-fpm
```
4. **Konfigurasi NGINX /etc/nginx/sites-available/default**
```nginx
	server {
		listen 80;
		server_name mbclab.online;

		root /var/www/html/mbc-landing-page;
		index index.html index.php;

		location / {
			try_files $uri $uri/ =404;
		}

		location ~ \.php$ {
			include snippets/fastcgi-php.conf;
			fastcgi_pass unix:/run/php/php8.1-fpm.sock;
		}
	}
```
5. **Reload Nginx**
```bash
sudo nginx -t
sudo systemctl reload nginx
```


# 📄KONFIGURASI SSL DAN BACKEND
### 🔒 KONFIGURASI SSL
1. **Install Certbot**
```bash
sudo apt install certbot python3-certbot-nginx
```
2. **Jalankan Certbot**
```bash
sudo certbot --nginx -d mbclab.online
```
### 🛠️ KONFIGURASI BACKEND
#### Crowdsec
1. **Instalasi Crowdsec**
```bash
curl -s https://packagecloud.io/install/repositories/crowdsec/crowdsec/script.deb.sh | sudo bash
sudo apt install crowdsec
```
2. **Menginstall Bouncer**
```bash
sudo apt install crowdsec-collections crowdsec-nginx-bouncer
```
3. **Menginstall Koleksi Khusus Nginx**
```bash
sudo cscli collections install crowdsecurity/nginx
```
4. **Setup Dashboard Dan Restart Crowdsec**
```bash
sudo cscli dashboard setup --listen 0.0.0.0
sudo systemctl restart crowdsec
```
#### Wazuh (Docker, Single-Node)
1. **Clone Repo Dari Official Website**
```bash
git clone https://github.com/wazuh/wazuh-docker.git -b v4.12.0
```
2. **Masuk Ke Direktori /home/devadmin/wazuh-docker/single-node/**
```bash
docker-compose -f generate-indexer-certs.yml run --rm generator
```
3. **Menggunakan Docker-Compose Untuk Menginstal Banyak Komponen Dan Mengaktifkan Wazuh Docker**
```bash
docker-compose up -d
```
### Pengiriman Email
Dengan PHPMailer
- Konfigurasi send-message.php untuk menggunakan SMTP provider (misalnya Gmail, Mailgun).

- Pastikan file .env atau konfigurasi PHP berisi kredensial SMTP.
### Keamanan
- SSL dengan Let's Encrypt dari Certbot
- Dashboard monitoring via CrowdSec + Wazuh
- CSCLI menangani brute-force dan log analisis