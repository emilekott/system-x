<?php

function systemx_distribution_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
    
    if (!empty($breadcrumb)) {
        // Provide a navigational heading to give context for breadcrumb links to
        // screen-reader users. Make the heading invisible with .element-invisible.
        $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

        $crumbs = '<div class="breadcrumb">';
        $arrow = '<img class="breadcrumb-arrow" src="'.base_path().path_to_theme().'/images/breadcrumb-arrow.png" />';
        $array_size = count($breadcrumb);
        $i = 0;
        while ($i < $array_size) {
            $crumbs .= '<span class="breadcrumb-' . $i;
            if ($i == 0) {
                $crumbs .= ' first';
            }
            /* if ($i+1 == $array_size) {
              $crumbs .= ' last';
              } */
            
            $crumbs .= '">' . $breadcrumb[$i] . '</span>'.$arrow;
            $i++;
        }
        
        $crumbs .= '<span class="active">' . drupal_get_title() . '</span></div>';
        return $crumbs;
    }
}

function systemx_distribution_preprocess_html(&$variables) {
    $element = array(
        '#type' => 'html_tag',
        '#tag' => 'meta',
        '#attributes' => array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge'),
        '#weight' => -1001,
    );
    drupal_add_html_head($element, 'chrome_frame');
}


/**
 * Returns HTML for an Colorbox image field formatter.
 *
 * @param $variables
 *   An associative array containing:
 *   - item: An array of image data.
 *   - image_style: An optional image style.
 *   - path: An array containing the link 'path' and link 'options'.
 *
 * @ingroup themeable
 */
function systemx_distribution_colorbox_image_formatter($variables) {
  $item = $variables['item'];
  $node = $variables['node'];
  $field = $variables['field'];
  $settings = $variables['display_settings'];
  $inline_caption ="";
  if ($item['title']){
      $inline_caption = '<div class="inline-caption">'.$item['title']."</div>";
  }
  
  $image = array(
    'path' => $item['uri'],
    'alt' => $item['alt'],
    'title' => $item['title'],
    'style_name' => $settings['colorbox_node_style'],
  );

  if (isset($item['width']) && isset($item['height'])) {
    $image['width'] = $item['width'];
    $image['height'] = $item['height'];
  }

  switch ($settings['colorbox_caption']) {
     case 'auto':
      // If the title is empty use alt or the node title in that order.
      if (!empty($image['title'])) {
        $caption = $image['title'];
      }
      elseif (!empty($image['alt'])) {
        $caption = $image['alt'];
      }
      elseif (!empty($node->title)) {
        $caption = $node->title;
      }
      else {
        $caption = '';
      }
      break;
    case 'title':
      $caption = $image['title'];
      break;
    case 'alt':
      $caption = $image['alt'];
      break;
    case 'node_title':
      $caption = $node->title;
      break;
    case 'custom':
      $caption = token_replace($settings['colorbox_caption_custom'], array('node' => $node));
      break;
    default:
      $caption = '';
  }

  // Shorten the caption for the example styles or when caption shortening is active.
  $colorbox_style = variable_get('colorbox_style', 'default');
  $trim_length = variable_get('colorbox_caption_trim_length', 75);
  if (((strpos($colorbox_style, 'colorbox/example') !== FALSE) || variable_get('colorbox_caption_trim', 0)) && (drupal_strlen($caption) > $trim_length)) {
    $caption = drupal_substr($caption, 0, $trim_length - 5) . '...';
  }

  // Build the gallery id.
  $nid = !empty($node->nid) ? $node->nid : 'nid';
  switch ($settings['colorbox_gallery']) {
    case 'post':
      $gallery_id = 'gallery-' . $nid;
      break;
    case 'page':
      $gallery_id = 'gallery-all';
      break;
    case 'field_post':
      $gallery_id = 'gallery-' . $nid . '-' . $field['field_name'];
      break;
    case 'field_page':
      $gallery_id = 'gallery-' . $field['field_name'];
      break;
    case 'custom':
      $gallery_id = $settings['colorbox_gallery_custom'];
      break;
    default:
      $gallery_id = '';
  }

  if ($style_name = $settings['colorbox_image_style']) {
    $path = image_style_url($style_name, $image['path']);
  }
  else {
    $path = file_create_url($image['path']);
  }
  
  return theme('colorbox_imagefield', array('image' => $image, 'path' => $path, 'title' => $caption, 'gid' => $gallery_id)).$inline_caption;
}

function systemx_distribution_uc_cart_block_content($variables) {
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
    //$output .= '<a href="#" class="copy-button">Copy Cart To Clipboard</a>';

    //build hidden paragraph to copy to clipboard
    $paragraph = "";
    
    foreach ($items as $item) {
        // Add the basic row with quantity, title, and price.
        //dsm($item);
        $node = node_load($item['nid']);
        $sku = $node->model;
        
        $paragraph .= $item['qty'] ." (".$sku.") ". strip_tags($item['title']).'<br />';    
    }
    
    $paragraph = '<div id="to-copy" style="display:none"><pre>ORDER DETAILS<br />'.$paragraph.'</pre></div>';
    $paragraph .= '<br /><br />';
    
    $output .= $paragraph;






    return $output;
}

