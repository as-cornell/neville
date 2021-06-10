<?php

namespace Drupal\as_courses\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class CoursesController.
 */
class CoursesController extends ControllerBase {

  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: display')
    ];
  }

}
