README
======


Développement Uniquement sur Linux

Installation Apache2 + mysqld:
===========================
apt-get install apache2
apt-get install mysqld (va vous demander le mot de passe pour le root de mysql)



=====================

The following is a sample VHOST you might want to consider for your project.

Configuration du hosts:

Add in (Linux) /etc/hosts 

127.0.0.1    InssetAirlines.spesx.com

=======================
Paramètrage du VHOST


<VirtualHost *:80>
   DocumentRoot "/Path/To/InssetAirlines/public"
   ServerName InssetAirlines.spesx.com

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "/Path/To/InssetAirlines/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride None
       Order allow,deny
       Allow from all
       php_value include_path ".:Path/to/Zend/Library:/Path/TO/PHPLibrary"

       RewriteEngine On
       RewriteCond %{REQUEST_FILENAME} -s [OR]
       RewriteCond %{REQUEST_FILENAME} -l [OR]
       RewriteCond %{REQUEST_FILENAME} -d
       RewriteRule ^.*$ - [NC,L]
       RewriteRule ^.*$ index.php [NC,L]

   </Directory>

</VirtualHost>


======================================
Module Apache2 à charger

cache.load
mem_cache.conf
mem_cache.load
rewrite.load
ssl.conf
ssl.load
headers.load
deflate.conf
deflate.load

ln -s /etc/apache2/mods-available/MonModule /etc/apache2/mods-enabled/


