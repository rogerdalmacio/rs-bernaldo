# docker/web_server.dockerfile

# Use official Nginx image
FROM nginx:alpine

WORKDIR /var/www

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Expose port 80
EXPOSE 80

# Start Nginx in the foreground (Docker requires this)
CMD ["nginx", "-g", "daemon off;"]
