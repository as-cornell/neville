<?php

namespace Drupal\as_dept_people_stub\Plugin\migrate\process;

use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;
use Drupal\taxonomy\Entity\Term;

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
      // replace department name with domain key
      $deptname = explode(',', $value)[0];
      //simple find and replace with array
      //$deptname = 'History';
      //$departments = array('Molecular Biology and Genetics', 'Institute for Comparative Modernities', 'American Studies Program','Government', 'Music' );
      //$domainids   = array('mbg_as_cornell_edu', 'icmdev_as_cornell_edu', 'americanstudies_as_cornell_edu', 'government_as_cornell_edu', 'music_as_cornell_edu');
      //$domainmap = str_replace($departments, $domainids, $deptname);
      //use entity query to look up domain id
      $domainmap = as_dept_people_stub_map_dept_domain($deptname);
      }
    }
    catch (\Exception $e) {
      throw new MigrateException('Invalid department name.');
    }
    return $domainmap;
  }
}
