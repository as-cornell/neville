<?php

namespace Drupal\as_dept_people_json\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\as_page_components\Entity\PageComponentEntityInterface;


class PeopleController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   */
  public function content($pathtoken) {
    $uuid ='';
    $path = 'https://asd8.as.cornell.edu/people/'.$pathtoken;
    // get people uuids from path
      $pids = \Drupal::entityQuery('page_component_entity')
        ->condition('type', 'person')
        ->condition('field_link.uri', $path)
        ->execute();
    foreach($pids as $key => $value)
      {
        $page_component_entity = $this->entityManager()->getStorage('page_component_entity')->load($value);
        $uuid = $page_component_entity->get('field_people_uuid')->value;
      }

    return [
      '#theme' => 'person',
      '#pathtoken' => $this->t($uuid),
    ];
  }

}
