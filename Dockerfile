# Set the base image for subsequent instructions
FROM php:8.2-apache

# Copy the startup script
COPY docker/startup.sh /startup.sh

# Make sure the startup script is executable
RUN chmod +x /startup.sh

# Update packages
RUN apt-get update

# Install system dependencies
RUN apt-get install -y \
    git \
    curl \
    libjpeg-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev

RUN apt-get update -q && apt-get install -y default-postgresql-client

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Install XDebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer
RUN curl --silent --show-error "https://getcomposer.org/installer" | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["/startup.sh"]
