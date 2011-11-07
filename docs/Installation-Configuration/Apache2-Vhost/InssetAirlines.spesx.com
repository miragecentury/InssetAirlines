<VirtualHost *:80>
   DocumentRoot "/var/www/InssetAirlines/public"
   ServerName InssetAirlines.spesx.com

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "/var/www/InssetAirlines/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride None
       Order allow,deny
       Allow from all
       php_value include_path ".:/var/www/PHPLibrary/:/var/www/Library/ZendFramework-1.11.11/library/"

       RewriteEngine On
       RewriteCond %{REQUEST_FILENAME} -s [OR]
       RewriteCond %{REQUEST_FILENAME} -l [OR]
       RewriteCond %{REQUEST_FILENAME} -d
       RewriteRule ^.*$ - [NC,L]
       RewriteRule ^.*$ index.php [NC,L]

   </Directory>

</VirtualHost>