<?php

namespace Drupal\as_dept_site_settings\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a Current Events Block.
 *
 * @Block(
 *   id = "college_header_logos_block",
 *   admin_label = @Translation("College Header Logos Block"),
 *   category = @Translation("Site Layout"),
 * )
 */
class ASCollegeHeaderLogos extends BlockBase implements BlockPluginInterface {


  /**
   * {@inheritdoc}
   */


  public function build() {

    $build = [];
    $markup = '';
    //$config = $this->getConfiguration();
    $build['college_header_logos_block']['#markup'] = $markup;


    return $build;
  }
}
