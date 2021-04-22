<?php

namespace Drupal\as_dept_people_json\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a Current Events Block.
 *
 * @Block(
 *   id = "person_card_block",
 *   admin_label = @Translation("Person Card Block"),
 *   category = @Translation("People"),
 * )
 */
class ASPersonCard extends BlockBase implements BlockPluginInterface {


  /**
   * {@inheritdoc}
   */


public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['netid'])) {
      $netid = $config['netid'];
      //print $config['netid'];
    }
    $build = [];
    $markup = "";
    // get people data from json
    $people_json = as_people_json_get_person_json($netid);
    if (!empty($people_json['data'])) {
      // get image path from json
      foreach($people_json['included'] as $image) {
          $imagepath = $image['attributes']['uri']['url'];
      }
      foreach($people_json['data'] as $person_data) {
          $alt = $person_data['relationships']['field_image']['data']['meta']['alt'];
          $path = $person_data['attributes']['path']['alias'];
          $title = $person_data['attributes']['title'];
          $jobtitle = $person_data['attributes']['field_person_title'];
          // get department label from json
          foreach($person_data['relationships']['field_departments_programs']['data'] as $dept_data) {
            $deptuuid = $dept_data['id'];
            $dept_json = as_people_json_get_dept_json($deptuuid);
            $departments = $departments . $dept_json['data']['attributes']['name'] . ', ';
          }
      }
      // Create the markup
      $markup = '<div> <img src="https://people.asd8.as.cornell.edu' . $imagepath .'" alt="'.$alt.'"></div>';
      $markup = $markup . '<div><a href="/as_people_json/'. $netid .'">' . $title . '</a></div>';
      if ($jobtitle) {
        $markup = $markup . '<div>' . $jobtitle .'</div>';
      }
      if ($departments) {
        $markup = $markup . '<div>' . rtrim($departments, ', ') .'</div>';
      }
      $build['person_card_block']['#markup'] = $markup;
    }
    //else {
      // There were no people
      //$build['person_card_block']['#markup'] = '<main>
                //<p>No people record for '. $netid .'.</p>
                //</main>';
   // }

    return $build;
  }
}
