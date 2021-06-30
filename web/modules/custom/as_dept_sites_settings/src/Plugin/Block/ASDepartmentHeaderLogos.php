<?php

namespace Drupal\as_dept_site_settings\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a Current Events Block.
 *
 * @Block(
 *   id = "department_header_logos_block",
 *   admin_label = @Translation("Department Header Logos Block"),
 *   category = @Translation("Site Layout"),
 * )
 */
class ASDepartmentHeaderLogos extends BlockBase implements BlockPluginInterface {


  /**
   * {@inheritdoc}
   */


  public function build() {

    $build = [];
    $markup = '';
    //$config = $this->getConfiguration();
    $build['department_header_logos_block']['#markup'] = $markup;


    return $build;
  }
}
