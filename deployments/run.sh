pip install -r requirements.txt && \
sh scripts/runserver.sh && \
mkdir -p -m 0777 /var/www/ifgl_frontend/frontend/web/uploads/ && \
chmod -R 777 /var/www/ifgl_frontend && \
dnf install nfs-utils nfs4-acl-tools && \
showmount -e 10.10.20.200 && \
mount -t nfs 10.10.20.200:/var/www/ifgl_frontend/frontend/web/uploads/ /var/www/ifgl_frontend/frontend/web/uploads/ && \
echo "10.10.20.200:/var/www/ifgl-frontend/frontend/web/uploads/ /var/www/ifgl-frontend/frontend/web/uploads/ nfs defaults 0 0">>/etc/fstab