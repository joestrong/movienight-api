FROM nginx:latest

COPY docker/app/nginx-host.conf /etc/nginx/conf.d/default.conf

COPY ./ /web

CMD ["nginx", "-g", "daemon off;"]
