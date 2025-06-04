<?php

/*
 * Define Variables
 */
if (!defined('THEME_DIR'))
    define('THEME_DIR', get_template_directory());
if (!defined('THEME_URL'))
    define('THEME_URL', get_template_directory_uri());


/*
 * Include framework files
 */
foreach (glob(THEME_DIR . '-child' . "/includes/*.php") as $file_name) {
    require_once($file_name);
}

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

add_action('woocommerce_single_product_summary', 'custom_stock_progress_bar_with_dynamic_sales', 20);
function custom_stock_progress_bar_with_dynamic_sales()
{
    global $product;

    if (!$product->is_in_stock()) return;

    $stock_quantity = $product->get_stock_quantity();
    $product_id = $product->get_id();
    $hours = 24;

    if ($stock_quantity >= 10) return;


    $date_from = (new DateTime())->modify("-$hours hours")->format('Y-m-d H:i:s');

    $orders = wc_get_orders([
        'limit'        => -1,
        'status'       => ['on-hold'],
        'date_created' => '>' . $date_from,
        'return'       => 'ids',
    ]);

    $sold_recent = 0;

    foreach ($orders as $order_id) {
        $order = wc_get_order($order_id);
        foreach ($order->get_items() as $item) {
            if ($item->get_product_id() == $product_id) {
                $sold_recent += $item->get_quantity();
            }
        }
    }

    $total_units = $stock_quantity + $sold_recent;
    if ($total_units == 0) return;
    $sold_percentage = ($sold_recent / $total_units) * 100;

    echo '<div class="custom-stock-alert">';
    echo '<p class="stock-warning">⏳ Hurry! Only <strong>' . $stock_quantity . '</strong> left in stock</p>';
    echo '<div class="stock-progress-bar">';
    echo '<div class="stock-progress-fill" style="width:' . $sold_percentage . '%"></div>';
    echo '</div>';
    echo '<p class="sold-recently">🔥 ' . $sold_recent . ' sold in last ' . $hours . ' hours</p>';
    echo '</div>';
}
