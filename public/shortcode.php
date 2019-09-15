<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class psNwsLetterShortCode
 */
class psWishlistShortCode
{

    /**
     * @var
     */
    public static $_instance;

    /**
     * @var string
     */
    public $plugin_version = '1.0.0';

    /**
     * @var
     */
    public $base;

    /**
     * @var string
     */
    public $file = __FILE__;


    /**
     * psNwsLetterShortCode constructor.
     */
    public function __construct()
    {
        $this->psInitShortCode();
    }

    /**
     *
     */
    public function psInitShortCode()
    {
        add_shortcode('ps_wishlist', array($this, 'psShowShortCode'));
    }

    /**
     * @param $atts
     * @param null $content
     * @return false|string
     */
    public function psShowShortCode($atts, $content = NULL)
    {
        $wishlist = ps_get_cookie('ps_wishlist');
        ob_start();
        ?>
        <table class="ps_wishlist_table">
            <thead>
            <tr>
                <th> <?php echo esc_html__('Action', 'ps-wishlist') ?></th>
                <th class="product-thumbnail"><?php echo esc_html__('Product Image', 'ps-wishlist') ?></th>
                <th class="product-name"><?php echo esc_html__('Product Name', 'ps-wishlist') ?></th>
                <th class="product-price"> <?php echo esc_html__('Unit Price', 'ps-wishlist') ?> </th>
                <th class="product-stock-status"> <?php echo esc_html__('Stock Status', 'ps-wishlist') ?> </th>
            </tr>
            </thead>
            <tbody>
            <?php if (is_array($wishlist) && !empty($wishlist)): ?>
                <?php foreach ($wishlist as $product_id): ?>
                    <?php $product = wc_get_product($product_id); ?>
                    <tr>
                        <td><a href="" class="ps_remove_wishlist" data-product-id="<?php echo esc_attr($product_id)?>"><span class="dashicons dashicons-trash"></span></a></td>
                        <td><?php echo $product->get_image(); ?></td>
                        <td><a href="<?php echo esc_url(get_permalink($product_id)) ?>"><?php echo $product->get_title(); ?></a></td>
                        <td><?php echo $product->get_price_html(); ?></td>
                        <td><?php echo $product->get_stock_status(); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5"><?php echo esc_html__('No wishlist found', 'ps-wishlist'); ?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    }

    /**
     * @return psWishlistShortCode
     */

    public static function psInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new psWishlistShortCode();
        }
        return self::$_instance;
    }

}

$psWishlistShortCode = psWishlistShortCode::psInstance();

?>