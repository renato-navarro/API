FROM php:8.2-fpm-alpine

# Instala o servidor web Nginx
RUN apk add --no-cache nginx

# Copia os arquivos de configuração do Nginx e do PHP-FPM
COPY nginx.conf /etc/nginx/nginx.conf
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

# Copia o código da sua aplicação para o diretório raiz do servidor web
COPY . /var/www/html/

# Define o diretório de trabalho
WORKDIR /var/www/html

# Expõe a porta 80 do servidor web
EXPOSE 80

# Comando para iniciar o PHP-FPM e o Nginx
CMD php-fpm -F & nginx -g "daemon off;"