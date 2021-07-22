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
      //$deptname = explode(',', $value)[0];
      $deptname = $value;
      //use entity query to look up domain id
      //$domainmap = as_dept_people_stub_map_dept_domain($deptname);
      $termids = \Drupal::entityQuery('taxonomy_term')
        ->condition('vid', 'departments_programs')
        ->condition('name', $deptname)
        ->execute();
        if (!empty($termids)){
          foreach($termids as $tid)
            {
              $term = Term::load($tid);
              $domainid = $term->get('field_domain_access_target_id')->value;
            }
          }
      }
    }
    catch (\Exception $e) {
      throw new MigrateException('Invalid department name.');
    }
    return $domainmap;
  }
}
