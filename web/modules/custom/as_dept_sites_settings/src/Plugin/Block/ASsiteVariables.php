<?php

namespace Drupal\as_dept_site_settings\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a Site Footer Block.
 *
 * @Block(
 *   id = "site_footer_block",
 *   admin_label = @Translation("Department Footer Site Settings Block"),
 *   category = @Translation("Site Layout"),
 * )
 */
class ASsiteVariables extends BlockBase implements BlockPluginInterface {


  /**
   * {@inheritdoc}
   */


  public function build() {

    $build = [];
    $markup = '';
    //$config = $this->getConfiguration();
    $build['site_footer_block']['#markup'] = $markup;


    return $build;
  }
}
