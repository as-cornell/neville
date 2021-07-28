<?php

namespace Drupal\as_dept_articles_migrate\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;


/**
 * Clean article title to remove special characters
 *
 * @MigrateProcessPlugin(
 *   id = "cleantitle",
 * )
 */
class CleanTitle extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    try {

    if (!empty($value)) {
      // decode special characters
      $cleantitle = htmlspecialchars_decode($value);
      $cleantitle = html_entity_decode($cleantitle, ENT_QUOTES, 'UTF-8');
      //dump($cleantitle);
      }
    }
    catch (\Exception $e) {
      throw new MigrateException('Invalid department name.');
    }
    //dump($cleantitle);
    return $cleantitle;
  }
}
