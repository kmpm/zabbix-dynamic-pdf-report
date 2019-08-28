Install zabbix-dynamic-pdf-report
=================================
All these examples are on a Ubuntu 18.04 server and assumes that you have
used the supplied packages for Apache and PHP and already have
Zabbix Installed.

## Get the code
```shell
    cd /usr/local/share
    git clone https://github.com/kmpm/zabbix-dynamic-pdf-report
    sudo apt-get install php7.2 php7.2-cli php7.2-curl
```


## Configure Apache2
/etc/apache2/conf.d/reports.conf
```
<IfModule mod_alias.c>
    Alias /reports /usr/local/share/zabbix-dynamic-pdf-report
</IfModule>

<Directory "/usr/local/share/zabbix-dynamic-pdf-report">
    Require all granted
</Directory>
```