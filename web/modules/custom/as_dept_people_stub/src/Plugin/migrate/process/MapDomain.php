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
      //$domainstring = $value;
      $deptname = explode(',', $value)[0];
      //$deptname = 'History';
      $departments = array('Molecular Biology and Genetics', 'Institute for Comparative Modernities', 'American Studies Program','Government', 'Music' );
      $domainids   = array('mbg_as_cornell_edu', 'icmdev_as_cornell_edu', 'americanstudies_as_cornell_edu', 'government_as_cornell_edu', 'music_as_cornell_edu');
      $domainmap = str_replace($departments, $domainids, $deptname);

     // $termids = \Drupal::entityQuery('taxonomy_term')
       // ->condition('vid', 'departments_programs')
       // ->condition('name', $deptname)
       // ->execute();
       // if (!empty($termids)){
         // foreach($termids as $tid)
           // {
             // $term = Term::load($tid);
             // $domainid = $term->get('field_domain_access_target_id')->value;
            //}
          //}
      }
    }
    catch (\Exception $e) {
      throw new MigrateException('Invalid department name.');
    }
    return $domainmap;
  }
}
