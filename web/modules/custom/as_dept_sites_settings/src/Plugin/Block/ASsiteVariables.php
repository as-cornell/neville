<?php

namespace Drupal\as_dept_site_settings\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a Current Events Block.
 *
 * @Block(
 *   id = "site_variables_block",
 *   admin_label = @Translation("Department Site Settings Block"),
 *   category = @Translation("Departments"),
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
    $build['events_block']['#markup'] = $markup;


    return $build;
  }
}
