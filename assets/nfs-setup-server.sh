dnf install nfs-utils && \
systemctl start nfs-server.service && \
systemctl start nfs-server.service && \
systemctl status nfs-server.service && \
echo "/var/www/ifgl-frontend/frontend/web/uploads/ 10.10.1.150(rw,sync,no_all_squash,root_squash)">>/etc/exports && \
exportfs -arv && \
exportfs  -s