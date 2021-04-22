<?php

namespace Drupal\as_dept_people_stub\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Format baseline start date.
 *
 * @MigrateProcessPlugin(
 *   id = "mapdomain",
 * )
 */
class MapDomain extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    try {
      if (!empty($value)) {
        //if ($value == 'Molecular Biology and Genetics') {
          //$value = 'dept1_as_cornell_edu';
       // }
        //elseif ($value == 'Music') {
          //$value = 'dept2_as_cornell_edu';
        //}
        //elseif ($value == 'Romance Studies') {
          //$value = 'dept3_as_cornell_edu';
        //}
        //elseif ($value == 'Government') {
          //$value = 'dept4_as_cornell_edu';
        //}else{
          $domain = 'dept5_as_cornell_edu';
        //}

      }
    }
    catch (\Exception $e) {
      throw new MigrateException('Invalid department name.');
    }
    return $domain;
  }
}
