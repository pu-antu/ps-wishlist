<?php
/**
 *
 * public Global Form subscriptions
 *
 */

add_action('wp_ajax_nopriv_ps_wishlist_add', 'ps_wishlist_add');
add_action('wp_ajax_ps_wishlist_add', 'ps_wishlist_add');
if (!function_exists('ps_wishlist_add')) {
    /**
     * add wishlist
     */
    function ps_wishlist_add()
    {
        check_ajax_referer('ps_security_check_wishlist', 'ps_security');
        if (defined('DOING_AJAX') && DOING_AJAX) {
            $product_id = $_POST['product_id'];
            $pre_wishlist = ps_get_cookie('ps_wishlist');
            if (!in_array($product_id, $pre_wishlist)) {
                array_push($pre_wishlist, $product_id);
                ps_set_cookie('ps_wishlist', $pre_wishlist);
                return wp_send_json(array('status' => 'success'));
            } else {
                return wp_send_json(array('status' => 'exists'));
            }
            wp_die();
        }
    }
}

add_action('wp_ajax_nopriv_ps_wishlist_remove', 'ps_wishlist_remove');
add_action('wp_ajax_ps_wishlist_remove', 'ps_wishlist_remove');
if (!function_exists('ps_wishlist_remove')) {
    /**
     * Wishlist remove
     */
    function ps_wishlist_remove()
    {
        check_ajax_referer('ps_security_check_wishlist', 'ps_security');
        if (defined('DOING_AJAX') && DOING_AJAX) {
            $product_id = $_POST['product_id'];
            $pre_wishlist = ps_get_cookie('ps_wishlist');
            if (is_array($pre_wishlist)) {
                if (($remove_product_id = array_search($product_id, $pre_wishlist)) !== false) {
                    unset($pre_wishlist[$remove_product_id]);
                    ps_set_cookie('ps_wishlist', $pre_wishlist);
                    return wp_send_json(array('status' => 'success'));
                }
                return wp_send_json(array('status' => 'error'));
            }
            wp_die();
        }
    }
}

if (!function_exists('ps_get_cookie')) {

    /**
     * @param $name
     * @return array|mixed|object
     */
    function ps_get_cookie($name)
    {
        if (isset($_COOKIE[$name])) {
            return json_decode(stripslashes($_COOKIE[$name]), true);
        }
        return array();
    }
}


if (!function_exists('ps_set_cookie')) {

    /**
     * @param $name
     * @param array $value
     */
    function ps_set_cookie($name, $value = array())
    {
        $exp = time() + (60 * 60 * 24 * 30);

        $value = wp_json_encode($value);

        $_COOKIE[$name] = $value;
        wc_setcookie($name, $value, $exp);
    }
}

//echo ps_get_cookie('ps_wishlist');