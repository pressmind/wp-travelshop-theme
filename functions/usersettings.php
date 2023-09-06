<?php

function register_settings(){
    register_setting( 'tt-user-settings', 'tt-user-frontend-roles');
}
function user_settings() { ?>
    <div class="wrap">
        <?php
        $user_roles = get_option('tt-user-frontend-roles');
        ?>
        <form method="post" action="options.php">
            <?php settings_fields('tt-user-settings'); ?>
            <?php do_settings_sections('tt-user-settings'); ?>
            <h2>Rechtemanagement</h2>
            <table class="form-table">
                <tr valign="top">
                    <td>
                        <label for="tt-user-frontend-roles">Frontend User Rollen</label><br>
                        <textarea id="tt-user-frontend-roles" name="tt-user-frontend-roles" style="width: 300px; height: 100px;"><?php echo esc_attr($user_roles); ?></textarea>
                        <p>pro Zeile eine Rolle (Neben den Wordpress Standardrollen ist die Rolle "Benutzer" <br>
                            Standard und kann nicht geändert werden, bzw. muss hier auch nicht gelistet werden) <br>
                            Wird eine Rolle entfernt oder umbenannt werden allen Usern die diese Rolle besitzen die Rechte entzogen.<br>
                            Die User werden dann der Gruppe "Subscriber" bzw. Abonnent zugeordnet.
                        </p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php }
function admin_menu() {
    add_submenu_page('travelshop-wpsf-settings', __('pressmind', 'user_settings'), __('Travelshop Userroles', 'user_settings'), 'update_core', 'user_settings', 'user_settings');
}

function add_frontend_user_roles(){

    $current_roles = get_option('wp_user_roles', array());
    $frontendroles = get_option('tt-user-frontend-roles', array());

    // find current frontend user roles
    $current_frontend_roles = array();
    foreach($current_roles as $key => $role){
        if(isset($role['capabilities']['tt_frontend_user']) === true){
            $current_frontend_roles[] = $key;
        }
    }

    // create new roles
    $allowed_roles = array();
    if(empty($frontendroles) === false){
        $lines = explode("\n", trim($frontendroles));
        foreach($lines as $line){
            $line = trim($line);
            $role_name = sanitize_title($line);
            $allowed_roles[] = $role_name;

            // create role if not exists
            if(in_array($role_name, $current_frontend_roles) === false){
                //echo 'create role '.$line;
                add_role( $role_name, $line, array( 'read' => true, 'level_0' => true, 'tt_frontend_user' => true) );
            }
        }
    }

    // remove roles that are not longer exists
    foreach($current_frontend_roles as $role_name){
        if(in_array($role_name, $allowed_roles) === false){

            // remove this role from users and set to subscriber
            $users = get_users( array('role' => $role_name));
            foreach($users as $user){
                wp_update_user( array( 'ID' => $user->ID, 'role' => 'subscriber'));
            }

            remove_role($role_name);
            //@todo check pages with this role
        }
    }

    if(AGENCY_FUNCTIONALITY) {
        if(in_array('tsagency', $current_frontend_roles) === false) {
            add_role( 'tsagency', 'TSAgency', array( 'read' => true, 'level_0' => true, 'tt_frontend_user' => true) );
            $frontendroles .= "\nTSAgency";
            update_option('tt-user-frontend-roles',$frontendroles);
        }
        if ( !username_exists('TSAgency') ) {
            $userID = wp_create_user('TSAgency', 'CKX0JmnGsaiLjGAu$2w#xMj*BmvP$v', 'travelshop@pressmind.dev');
            $user = get_user_by( 'ID', $userID );
            $user->remove_role( 'subscriber' );
            $user->add_role( 'tsagency' );
        }
    }

}

function user_role_selector( $post ) {

    $value = get_post_meta( $post->ID, '_tt_user_roles_allowed', true);
    if(empty($value) === true){
        $value = array();
    }

    $current_roles = get_option('wp_user_roles');

    ?>
    <p>Freigeben nur für Benutzerrolle/n:<br>
        (mehrere mit "strg"-Taste selektieren)</p>

    <select name="tt_user_roles_allowed[]" autocomplete="off" multiple style="width:200px;height: 200px;">
        <?php foreach($current_roles as $key => $role){
            ?>
            <option value="<?php echo $key;?>" <?php echo (in_array($key, $value) === true) ? 'selected' : '';?>><?php echo $role['name'];?></option>
            <?php
        }?>
    </select>
    <?php

}

function add_meta_description() {
    add_meta_box( 'tt_user_role_selector', 'Berechtigung', 'user_role_selector', 'page', 'normal', 'high' );
    add_meta_box( 'tt_user_role_selector', 'Berechtigung', 'user_role_selector', 'post', 'normal', 'high' );
}

function save_page( $post_ID )
{
    global $post;

    if (isset($_GET['fl_builder']) === false && isset($post->post_type) && ($post->post_type == "page" || $post->post_type == "post" || $post->post_type == "tt_events")) {
        if (isset($_POST)) {

            if (isset($_POST['tt_meta_description']) === true) {
                update_post_meta($post_ID, '_tt_meta_description', strip_tags($_POST['tt_meta_description']));
            }

            if (isset($_POST['tt_meta_title']) === true) {
                update_post_meta($post_ID, '_tt_meta_title', strip_tags($_POST['tt_meta_title']));
            }

            if (isset($_POST['tt_meta_keywords']) === true) {
                update_post_meta($post_ID, '_tt_meta_keywords', strip_tags($_POST['tt_meta_keywords']));
            }

            if (isset($_POST['tt_do_not_cache']) === true && $_POST['tt_do_not_cache'] == "1") {
                update_post_meta($post_ID, '_tt_do_not_cache', 1);
            } else {
                update_post_meta($post_ID, '_tt_do_not_cache', 0);
            }

            if (isset($_POST['tt_do_not_index']) === true && $_POST['tt_do_not_index'] == "1") {
                update_post_meta($post_ID, '_tt_do_not_index', 1);
            } else {
                update_post_meta($post_ID, '_tt_do_not_index', 0);
            }

            if (isset($_POST['tt_redirect_to']) === true) {
                update_post_meta($post_ID, '_tt_redirect_to', strip_tags($_POST['tt_redirect_to']));
            }

            if (isset($_POST['tt_user_roles_allowed']) === true) {
                update_post_meta($post_ID, '_tt_user_roles_allowed', $_POST['tt_user_roles_allowed']);
            } else {
                update_post_meta($post_ID, '_tt_user_roles_allowed', array());
            }


            if (isset($_POST['tt_pressmind_category']) === true) {
                update_post_meta($post_ID, '_tt_pressmind_category', $_POST['tt_pressmind_category']);
            }

            if (isset($_POST['tt_page_notes']) === true) {
                update_post_meta($post_ID, '_tt_page_notes', $_POST['tt_page_notes']);
            }


            if (isset($_POST['tt_page_notes_show_in_frontend']) === true && $_POST['tt_page_notes_show_in_frontend'] == "1") {
                update_post_meta($post_ID, '_tt_page_notes_show_in_frontend', 1);
            } else {
                update_post_meta($post_ID, '_tt_page_notes_show_in_frontend', 0);
            }


        }
    }
}

add_action('admin_menu', 'admin_menu', 99);
add_action( 'admin_init', 'register_settings' );
add_action( 'admin_init', 'add_frontend_user_roles' );
add_action('add_meta_boxes', 'add_meta_description');
add_action('save_post', 'save_page');

function is_user_allowed_to_view_this_page($slug)
{

    global $wpdb, $table_prefix;


    /*
    // Fehlerhaft:
    $SQL = 'SELECT ID, meta_value FROM ' . $table_prefix . 'posts p
            left join ' . $table_prefix . 'postmeta pm on(p.ID = pm.post_id and meta_key = "_tt_user_roles_allowed")
            where post_name = "' . $slug . '"
            limit 1;';
    */


    // wenn dies zu langsam, dann mit WP Standard Funktion lösen get_page_by_path( $page_path, $output, $post_type );
    $SQL = 'select ID, pm.meta_value from (
                      SELECT
                        p1.ID,
                        p1.post_name,
                        p1.post_parent,
                        concat_ws(\'/\', p4.post_name, p3.post_name, p2.post_name, p1.post_name) AS path
                      FROM wp_posts p1
                        LEFT JOIN wp_posts p2 ON (p1.post_parent = p2.ID)
                        LEFT JOIN wp_posts p3 ON (p2.post_parent = p3.ID)
                        LEFT JOIN wp_posts p4 ON (p3.post_parent = p4.ID)
                        AND p1.post_parent > 0
                        and p1.post_type IN("page", "post")
                    ) as ts
                      LEFT JOIN wp_postmeta pm ON (ID = pm.post_id AND meta_key = "_tt_user_roles_allowed")
                    where path = \''.$slug.'\'
                    limit 1';

    $r = $wpdb->get_results($SQL);

    $tt_user_roles_allowed = array();
    if (empty($r[0]->meta_value) === false) { // if roles are set
        $tt_user_roles_allowed = unserialize($r[0]->meta_value);

        // if page roles are restricted
        if (empty($tt_user_roles_allowed) === false && is_array($tt_user_roles_allowed) && count($tt_user_roles_allowed) > 0) {
            // get users role

            $user = wp_get_current_user();
            if (count($user->roles) > 0) {
                $current_user_role = wp_get_current_user()->roles[0];
            } else {
                $current_user_role = 'not-logged-in'; // dummy
            }

            // check if user is allowed to view this page, admin can view all pages
            if ($current_user_role != 'administrator' && in_array($current_user_role, $tt_user_roles_allowed) === false) {
                return false; // user is not allowed
            }
        }
    }

    return true;

}

function get_wp_page_for_object_type($id_object_type)
{

    $object_type = get_option('tt-object-to-page-map-object-type', array());
    $page = get_option('tt-object-to-page-map-page', array());

    $r = array_search($id_object_type, $object_type);

    if ($r !== false && isset($page[$r]) === true && empty($page[$r]) === false) {
        return $page[$r];
    }

    return false;
}
function parse_request($query)
{
    global $wpdb, $table_prefix;

    # echo '<pre>'.print_r($query, true).'</pre>';exit;

    $id_media_object = false;
    $id_object_type = false;

    // if code is set, but not ids are found
    if (isset($query->query_vars['tt_code']) === true && (empty($id_media_object) === true || empty($id_object_type) === true)) {
        // Code not found, redirect to default search
        header("HTTP/1.1 302");
        header("location: " . site_url() . '/suche/?pm_code=' . $query->query_vars['tt_code']);
        exit;
    }


    // if wordpress detects a matching rule, the request is not 404, so we have to check if a page or post exists.
    $page_not_found = false;
    if (isset($query->query_vars['name']) === true && get_page_by_path($query->query_vars['name'], OBJECT, array('page', 'post')) === null) {
        $page_not_found = true;
    }

    #print_r($query);exit;


    // Route to media objects
    if (empty($id_media_object) === false && empty($id_object_type) === false) {

        $query->query_vars['pm_id_media_object'] = $id_media_object;

        // Check if this object type needs a redirect to an extra page (defined in Backend->Object Type Mapping)
        $r = get_wp_page_for_object_type($id_object_type);
        if ($r !== false) {
            $query->query_vars['pagename'] = $r;
        } else {
            $query->query_vars['pagename'] = 'detail';
        }

        unset($query->query_vars['error']); // reset the error
        unset($query->query_vars['name']); // reset name (this is for posts only)
    }


    // User roles per Page
    if (empty($query->query_vars['pagename']) === false) { // if pagename is set
        if (is_user_allowed_to_view_this_page($query->query_vars['pagename']) === false) { // the user is not allowed
            if (!isset($_COOKIE['id_user'])) {
                $query->query_vars['error'] = '404';
            } else {
                $cURLConnection = curl_init();
                $strCookie = 'id_user=' . $_COOKIE['id_user'] . '; path=/';
                curl_setopt($cURLConnection, CURLOPT_URL, TS_IBE3_BASE_URL . '/api/external/getUserData');
                curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cURLConnection, CURLOPT_COOKIE, $strCookie );
                $response = curl_exec($cURLConnection);
                curl_close($cURLConnection);
                if(!json_decode($response)->data->user->is_agency) { ?>
                    <!DOCTYPE html>
                    <html lang="de">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Fehlermeldung</title>
                    </head>
                    <body style="font-family: Arial, sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; background-color: #f4f4f4;">

                    <div style="max-width: 800px; width: 100%; background-color: #ffffff; padding: 40px; border-radius: 10px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); text-align: center;">
                        <h1 style="margin: 0 0 20px; color: #333;">Ihr Nutzerkonto ist keiner Agentur zugeordnet. Bitte informieren Sie den Betreiber dieses Webangebots.</h1>
                        <a href="javascript:history.go(-2)" style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: #ffffff; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">Zurück zur letzten Seite</a>
                    </div>

                    </body>
                    </html>
                    <?php die(); ?>
                <?php }
            }
            //$query->query_vars['redirect'] = $query->query_vars['pagename']; // set redirect after login
            //$query->query_vars['pagename'] = 'profile/login';
        }
    } // user roles


    return $query;
}
// Register SE friendly url
add_action('parse_request', 'parse_request');

// Hide Admin bar for every user, except administrators
function ts_disable_admin_bar() {
    if (current_user_can('administrator') || current_user_can('contributor') ) {
        // user can view admin bar
        show_admin_bar(true); // this line isn't essentially needed by default...
    } else {
        // hide admin bar
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'ts_disable_admin_bar');
?>