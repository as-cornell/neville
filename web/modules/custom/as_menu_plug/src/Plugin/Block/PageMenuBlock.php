<?php

namespace Drupal\as_menu_plug\Plugin\Block;

use Drupal\Core\Block\BlockBase;


/**
 * Provides a 'PageMenuBlock' block speicifically for otpNav internal page items
 *
 * @Block(
 *  id = "page_menu_block",
 *  admin_label = @Translation("Page menu block"),
 * )
 */
class PageMenuBlock extends BlockBase
{



  /**
   * {@inheritdoc}
   */
  public function build()
  {

    $link_class = 'otpNav__item';
    $list_class = 'otpNav';
    $alias = '';
    $build = [];
    //$build['#theme'] = 'page_menu_block';
    $config = $this->getConfiguration();
    //get link values in an array
    if (!empty($config['link_values'])) {
      $link_values = $config['link_values'];
    }

    $build['page_menu_block']['#markup'] = '<ul class="' . $list_class . '">';

    if (!empty($link_values)) {
      foreach ($link_values as $link_title) {
        $build['page_menu_block']['#markup'] = $build['page_menu_block']['#markup'] . as_menu_plug_generate_link_markup($link_title, $alias, $link_class);
      }
    } // There were no links
    else {
      $build['page_menu_block']['#markup'] = $build['page_menu_block']['#markup'] . "<li>There are no in-page links</li>";
    }
    $build['page_menu_block']['#markup'] = $build['page_menu_block']['#markup'] . '</ul>';

    return $build;
  }
}
