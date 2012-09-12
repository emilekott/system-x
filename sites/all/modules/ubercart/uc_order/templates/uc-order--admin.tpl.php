<?php

/**
 * @file
 * This file is the default admin notification template for Ubercart.
 */
?>

<p>
<?php print t('Order number:'); ?> <?php print $order_admin_link; ?><br />
<?php print t('Customer:'); ?> <?php print $order_first_name; ?> <?php print $order_last_name; ?> - <?php print $order_email; ?><br />
<?php //print t('Order total:'); ?> <?php //print $order_total; ?><br />
<?php //print t('Shipping method:'); ?> <?php //print $order_shipping_method; ?>
</p>
<!-- Webform Panes -->
<?php
  $webforms = _uc_webform_pane_get_nodes();
  foreach ($webforms as $webform) {
    $nid = $webform->nid;
    $node = node_load($nid);
?>
    <tr>
      <td colspan="2" bgcolor="#006699">
        <b><?php echo t($node->title); ?></b>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <table border="0" cellpadding="1" cellspacing="0" width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
          <?php
            foreach ($node->webform['components'] as $field) {
          ?>
              <tr>
                <td nowrap="nowrap">
                  <b><?php 
                            if ($field['name']=='Your order ref.'){
                                echo t('Dealer order ref.');
                            }
                            else{
                                echo t($field['name']); 
                            }
                        ?>:</b>
                </td>
                <td width="98%">
                  <?php echo ${'order_webform_'.$nid.'_'.$field['form_key']}; ?>
                </td>
              </tr>  
          <?php
            }
          ?>
        </table>
      </td>
    </tr>
<?php
  }
?>
<!-- End Webform Panes -->

<p>
<?php print t('Products:'); ?><br />
<?php foreach ($products as $product): ?>
- <?php print $product->qty; ?> x <?php print $product->title; ?> - <?php // print $product->total_price; ?>
&nbsp;&nbsp;<?php print t('SKU'); ?>: <?php print $product->model; ?><br />
    <?php if (!empty($product->data['attributes'])): ?>
    <?php foreach ($product->data['attributes'] as $attribute => $option): ?>
    &nbsp;&nbsp;<?php print t('@attribute: @options', array('@attribute' => $attribute, '@options' => implode(', ', (array)$option))); ?><br />
    <?php endforeach; ?>
    <?php endif; ?>
<br />
<?php endforeach; ?>
</p>

<p>
<?php print t('Order comments:'); ?><br />
<?php print $order_comments; ?>
</p>
