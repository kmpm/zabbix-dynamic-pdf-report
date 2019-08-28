zabbix-dynamic-pdf-report
=========================

This originates from https://github.com/spy86/Zabbix_/zabbix-dynamic-pdf-report
and the goal of this fork is to create a standalone git repository
together with some installation instructions.

Also to make sure it works 100% with last LTS version.
At the time of writing the LTS version is Zabbix 4.0.

# Goals

* [ ] Make it work with 3.0 (LTS) - possibly
* [ ] Make it work with 4.0 (LTS) - yes, please
* [ ] Make it work with 4.2 - yes, please
* [ ] Make it work with 4.4 - who knows?


Installation
------------
```
#copy sample to real config
cp config.inc.sample.php config.inc.php

#edit to match your environment
nano config.inc.php

# configure your webserver
```
There are some more detaild installation instructions in [INSTALL.md](INSTALL.md)



develop
-------

* clone `https://github.com/kmpm/zabbix-dynamic-pdf-report`
* Install PHP `sudo apt-get install php7.0 php7.0-cli php7.0-curl`
