function get_query_template($type, $templates = array()) {
    $type = preg_replace('|[^a-z0-9-]+|', '', $type);

    if (empty($templates))
        $templates = array("{$type}.php");

    return apply_filters("{$type}_template", locate_template($templates));
}

function locate_template($template_names, $load = false, $require_once = true) {
    $located = '';
    foreach ((array) $template_names as $template_name) {
        if (!$template_name)
            continue;
        if (file_exists(STYLESHEETPATH . '/' . $template_name)) {
            $located = STYLESHEETPATH . '/' . $template_name;
            break;
        } else if (file_exists(TEMPLATEPATH . '/' . $template_name)) {
            $located = TEMPLATEPATH . '/' . $template_name;
            break;
        }
    }

    if ($load && '' != $located)
        load_template($located, $require_once);

    return $located;
}

function load_template($_template_file, $require_once = true) {
    global $posts, $post, $wp_did_header, $wp_did_template_redirect, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

    if (is_array($wp_query->query_vars))
        extract($wp_query->query_vars, EXTR_SKIP);

    if ($require_once)
        require_once( $_template_file );
    else
        require( $_template_file );
}
