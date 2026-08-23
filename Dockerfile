FROM php:8.3-apache

# نصب PostgreSQL و ابزارهای لازم
RUN apt-get update \
    && apt-get install -y libpq-dev unzip git \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# تنظیم پوشه سایت
WORKDIR /var/www/html

# کپی فایل‌های پروژه
COPY . /var/www/html/

# تنظیم Apache
RUN printf '%s\n' \
    '<VirtualHost *:80>' \
    '    DocumentRoot /var/www/html' \
    '    <Directory /var/www/html>' \
    '        AllowOverride All' \
    '        Require all granted' \
    '    </Directory>' \
    '    DirectoryIndex index.php' \
    '</VirtualHost>' \
    > /etc/apache2/sites-available/000-default.conf

# دسترسی فایل‌ها
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80