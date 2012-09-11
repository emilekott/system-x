<?php
/**
 * @file
 * latest_news.features.inc
 */

/**
 * Implements hook_views_api().
 */
function latest_news_views_api() {
  return array("version" => "3.0");
}

/**
 * Implements hook_image_default_styles().
 */
function latest_news_image_default_styles() {
  $styles = array();

  // Exported image style: mini.
  $styles['mini'] = array(
    'name' => 'mini',
    'effects' => array(
      3 => array(
        'label' => 'Scale and crop',
        'help' => 'Scale and crop will maintain the aspect-ratio of the original image, then crop the larger dimension. This is most useful for creating perfectly square thumbnails without stretching the image.',
        'effect callback' => 'image_scale_and_crop_effect',
        'dimensions callback' => 'image_resize_dimensions',
        'form callback' => 'image_resize_form',
        'summary theme' => 'image_resize_summary',
        'module' => 'image',
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => '60',
          'height' => '60',
        ),
        'weight' => '1',
      ),
    ),
  );

  return $styles;
}
