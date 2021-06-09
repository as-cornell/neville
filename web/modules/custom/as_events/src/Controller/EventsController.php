<?php

namespace Drupal\as_events\Controller;

use Drupal\Core\Controller\ControllerBase;

class EventsController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   */
  public function content($events_shown,$keyword_params) {
    $main = "";
    $event_count = 0;
    $events_json = as_events_get_events_json($events_shown,$keyword_params);

    if (!empty($events_json)) {
      foreach($events_json as $event_data) {
        if ($event_count <= $events_shown) {
          $main = $main . as_events_generate_event_item_markup($event_data);
          $event_count++;
        }

      }

    } // There were no events
    else {
      $main = "<main>
                <h1>Calendar</h1>
                <p>There are no Upcoming Events.</p>
                </main>";
    }
    return array(
      '#type' => 'markup',
      '#markup' => $this->t('<h1>Calendar Schizz</h1><div class="slides">
<article class="slide-aside">'.$main.'</article></div>'),
    );
  }

}
