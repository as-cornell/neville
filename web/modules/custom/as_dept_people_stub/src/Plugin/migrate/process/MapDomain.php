<?php

namespace Drupal\as_dept_people_stub\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Map departments_programs to domain access
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
        $domainstring = $value;
        // break string into title and uri
        $domainarray = explode(', ', $domainstring);
        $domains = array();
        foreach ($domainarray as $key => $domain) {

          if ($domain == 'Molecular Biology and Genetics') {
              $domain = 'dept1_as_cornell_edu';
            }
          elseif ($domain == 'Music') {
              $domain = 'dept2_as_cornell_edu';
            }
          elseif ($domain == 'Romance Studies') {
              $domain = 'dept3_as_cornell_edu';
            }
          elseif ($domain == 'Government') {
              $domain = 'dept4_as_cornell_edu';
            }else{
              $domain = 'dept5_as_cornell_edu';
            }
            $domains[$key]['domain'] = $domain;

          }
        }
      }
    }
    catch (\Exception $e) {
      throw new MigrateException('Invalid department name.');
    }
    return $domains;
  }
}
