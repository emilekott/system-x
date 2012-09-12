<?php

/**
 * Themes the shopping cart block content.
 *
 * @param $variables
 *   An associative array containing:
 *   - help_text: Text to place in the small help text area beneath the cart
 *     block title or FALSE if disabled.
 *   - items: An associative array of cart item information containing:
 *     - qty: Quantity in cart.
 *     - title: Item title.
 *     - price: Item price.
 *     - desc: Item description.
 *   - item_count: The number of items in the shopping cart.
 *   - item_text: A textual representation of the number of items in the
 *     shopping cart.
 *   - total: The unformatted total of all the products in the shopping cart.
 *   - summary_links: An array of links used in the cart summary.
 *   - collapsed: TRUE or FALSE indicating whether or not the cart block is
 *     collapsed.
 *
 * @ingroup themeable
 */
function acquia_marina_uc_cart_block_content($variables) {
    $help_text = $variables['help_text'];
    $items = $variables['items'];
    $item_count = $variables['item_count'];
    $item_text = $variables['item_text'];
    $total = $variables['total'];
    $summary_links = $variables['summary_links'];
    $collapsed = $variables['collapsed'];

    $output = '';
    
    // Add the help text if enabled.
    if ($help_text) {
        $output .= '<span class="cart-help-text">' . $help_text . '</span>';
    }

    // Add a table of items in the cart or the empty message.
    $output .= theme('uc_cart_block_items', array('items' => $items, 'collapsed' => $collapsed));

    // Add the summary section beneath the items table.
    
    
    $output .= theme('uc_cart_block_summary', array('item_count' => $item_count, 'item_text' => $item_text, 'total' => $total, 'summary_links' => $summary_links));
    $output .= '<a href="#" class="copy-button">Copy Cart To Clipboard</a>';

    //build hidden paragraph to copy to clipboard
    $paragraph = "";
    
    foreach ($items as $item) {
        // Add the basic row with quantity, title, and price.
        //dsm($item);
        $node = node_load($item['nid']);
        $sku = $node->model;
        
        $paragraph .= $item['qty'] ." (".$sku.") ". strip_tags($item['title']).'<br />';    
    }
    
    $paragraph = '<div id="to-copy" style="display:none">ORDER DETAILS<br />'.$paragraph.'</div>';
    $paragraph .= '<br /><br />';
    
    $output .= $paragraph;






    return $output;
}