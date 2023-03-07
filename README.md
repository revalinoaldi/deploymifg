<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Rest API nginx config</h1>
    <br>
</p>


NGINX CONFIGURATION
-------------------

```
#load_module "modules/ngx_http_image_filter_module.so";
#load_module "modules/ngx_http_perl_module.so";
#load_module "modules/ngx_http_xslt_filter_module.so";
#load_module "modules/ngx_mail_module.so";
#load_module "modules/ngx_stream_module.so";

user                         root admin;
worker_processes             2;

events {
    worker_connections       1024;
}

http {
    include                  mime.types;
    default_type             text/html;
    gzip                     on;
    gzip_types               text/css text/x-component application/x-javascript application/javascript text/javascript text/x-js text/richtext image/svg+xml text/plain text/xsd text/xsl text/xml image/x-icon;
    
    sendfile                 on;

    server {
        listen               80 default_server;

        root /Users/suburlegowo/Documents/www/ptpos/api/web;
        #root /Users/suburlegowo/Documents/www/mrbs/web;
        index index.html index.php;

        # set expiration of assets to MAX for caching
        location ~* \.(ico|css|js|gif|jpe?g|png)(\?[0-9]+)?$ {
            expires max;
            log_not_found off;
        }

        location / {
            # Check if a file or directory index file exists, else route it to index.php.
            try_files $uri $uri/ /index.php;
        }

        location ~ \.php$ {
            try_files $uri =404;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass unix:/Applications/MAMP/Library/logs/fastcgi/nginxFastCGI.sock;
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            include fastcgi_params;
        }
    }

    # HTTPS server
    #
    #server {
    #    listen       443 ssl;
    #    server_name  localhost;

    #    ssl_certificate      cert.pem;
    #    ssl_certificate_key  cert.key;

    #    ssl_session_cache    shared:SSL:1m;
    #    ssl_session_timeout  5m;

    #    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    #    ssl_ciphers  HIGH:!aNULL:!MD5;
    #    ssl_prefer_server_ciphers  on;

    #    location / {
    #        root   html;
    #        index  index.html index.htm;
    #    }
    #}
}

```
