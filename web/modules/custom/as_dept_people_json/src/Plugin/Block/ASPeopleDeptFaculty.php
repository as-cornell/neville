<?php

namespace Drupal\as_dept_people_json\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a person list filtered by type=faculty and department tid.
 *
 * @Block(
 *   id = "people_dept_faculty_block",
 *   admin_label = @Translation("Department Faculty Block"),
 *   category = @Translation("People"),
 * )
 */
class ASPeopleDeptFaculty extends BlockBase implements BlockPluginInterface {


  /**
   * {@inheritdoc}
   */


public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['deptid'])) {
      $deptid = $config['deptid'];
    }
    $build = [];
    $markup = '';
    $departments = '';
    // get people data from json
    $department_json = as_people_json_get_department_faculty_json($deptid);
    //var_dump($department_json);
    //rtm9 3-27-21 add the whole associated faculty in here
    if (!empty($department_json['data'])) {
      // get image path from json
      //foreach($department_json['included'] as $image) {
          //$imagepath = $image['attributes']['uri']['url'];
      //}
      $markup = '<h3>Associated Faculty</h3><ul class="columns">';
      foreach($department_json['data'] as $person_data) {
          //$alt = $person_data['relationships']['field_image']['data']['meta']['alt'];
          $path = $person_data['attributes']['path']['alias'];
          $title = $person_data['attributes']['title'];
          //$jobtitle = $person_data['attributes']['field_person_title'];
          // get department label from json
          foreach($person_data['relationships']['field_departments_programs']['data'] as $dept_data) {
            $deptuuid = $dept_data['id'];
            $dept_json = as_people_json_get_dept_json($deptuuid);
            $departments = $departments . $dept_json['data']['attributes']['name'] . ', ';
          }
          $markup = $markup . '<li><a href="/people'. $path .'">' . $title . '</a></li>';
      }
      $markup = $markup . '</ul>';
    }
    //else {
      // There were no people
      //$build['person_card_block']['#markup'] = '<main>
                //<p>No people record for '. $netid .'.</p>
                //</main>';
   // }
$build['dept_faculty_block']['#markup'] = $markup;
    return $build;
  }
}
