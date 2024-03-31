<?php 
//HTACCESS
if(get_field('performance_redirect_https', 'option')):

    function trp_htaccess_redirect( $rules ) {	
        $rules .= '# REDIRECT HTTP: -> HTTPS:
    <IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R,L]
    </IfModule>
    ';

        return $rules;
    }
    add_filter('mod_rewrite_rules', 'trp_htaccess_redirect');
endif;


if(get_field('performance_cache_enabled', 'option')):

    function trp_htaccess_cache( $rules ) {
        $rules .= '# DEFLATE compressione
    <IfModule mod_deflate.c>
    # Compress HTML, CSS, JavaScript, Text, XML and fonts
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
    AddOutputFilterByType DEFLATE application/x-font
    AddOutputFilterByType DEFLATE application/x-font-opentype
    AddOutputFilterByType DEFLATE application/x-font-otf
    AddOutputFilterByType DEFLATE application/x-font-truetype
    AddOutputFilterByType DEFLATE application/x-font-ttf
    AddOutputFilterByType DEFLATE font/opentype
    AddOutputFilterByType DEFLATE font/otf
    AddOutputFilterByType DEFLATE font/ttf
    AddOutputFilterByType DEFLATE image/svg+xml
    AddOutputFilterByType DEFLATE image/x-icon
    AddOutputFilterByType DEFLATE image/jpg
    AddOutputFilterByType DEFLATE image/jpeg
    AddOutputFilterByType DEFLATE image/gif
    AddOutputFilterByType DEFLATE image/png
    # Remove browser bugs
    BrowserMatch ^Mozilla/4 gzip-only-text/html
    BrowserMatch ^Mozilla/4\.0[678] no-gzip
    BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
    Header append Vary User-Agent
    </IfModule>
    # FINE DEFLATE

    ## EXPIRES CACHING ##
    <IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 month"
    ExpiresByType image/x-icon "access 1 year"
    ExpiresByType audio/ogg "access plus 1 year"
    ExpiresByType video/ogg "access plus 1 year"
    ExpiresByType video/mp4 "access plus 1 year"
    ExpiresByType video/webm "access plus 1 year"
    ExpiresByType application/pdf "access 1 month"
    ExpiresByType application/javascript "access 1 month"
    ExpiresByType application/x-javascript "access 1 month"
    ExpiresByType text/javascript "access 1 month"
    ExpiresByType text/x-javascript "access 1 month"
    ExpiresByType application/x-shockwave-flash "access 1 month"
    </IfModule>
    ## EXPIRES CACHING ##
    ';

        return $rules;
    }
    add_filter('mod_rewrite_rules', 'trp_htaccess_cache');
endif;

function trp_htaccess_security( $rules ) {	
	$rules .= '# SICUREZZA: XML RPC BLOCKING
<Files xmlrpc.php>
Order Deny,Allow
Deny from all
</Files>
# SICUREZZA: XML RPC BLOCKING

# SICUREZZA: FILE SENSIBILI
<FilesMatch "(^\.|wp-config(-sample)*\.php)">
	order deny,allow
	deny from all
</FilesMatch>
# SICUREZZA: FILE SENSIBILI

# SICUREZZA: PHP ERRORS
<IfModule mod_php5.c>
php_flag display_errors off
</IfModule>
<IfModule mod_php7.c>
	php_flag display_errors off
</IfModule>
# SICUREZZA: PHP ERRORS

# SICUREZZA: LISTING PAGINE
Options -Indexes
# SICUREZZA: LISTING PAGINE
';

	return $rules;
}
add_filter('mod_rewrite_rules', 'trp_htaccess_security');