<?php
add_action( 'init',  function() {
    add_rewrite_rule( 'service-worker\.min\.js', 'wp-content/themes/travelshop/assets/js/service-worker.min.js', 'top' );
    add_rewrite_rule( 'placeholder\.svg(.*)', 'wp-content/themes/travelshop/placeholder.svg.php$1', 'top' );
});
add_filter('mod_rewrite_rules', function ( $rules )
{
    $str = <<<EOD
# WebP Support
# if you have a nginx proxy, use add this lines to your config:
# location ~* "^(?<path>.+)\.(png|jpeg|jpg|gif)$" {
#    try_files \$path.webp \$uri =404; 
# }
#
<IfModule mod_rewrite.c>
  RewriteEngine On
  # Check if browser supports WebP images
  RewriteCond %{HTTP_ACCEPT} image/webp
  # Check if WebP replacement image exists
  RewriteCond %{DOCUMENT_ROOT}/$1.webp -f
  # Serve WebP image instead
  RewriteRule (.+)\.(jpeg|jpg|png|gif)$ $1.webp [T=image/webp,E=REQUEST_image]
</IfModule>
<IfModule mod_headers.c>
  # Vary: Accept for all the requests to jpeg, png and gif
  Header append Vary Accept env=REQUEST_image
</IfModule>
<IfModule mod_mime.c>
  AddType image/webp .webp
</IfModule>
EOD;

    return $rules.$str;
});


// flush rewrite rules after changing this lines, usage wp-cli  $ wp rewrite flush --hard --allow-root