<?php

namespace Drupal\as_events\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a Current Events Block.
 *
 * @Block(
 *   id = "events_block",
 *   admin_label = @Translation("Events Block"),
 *   category = @Translation("Upcoming Events"),
 * )
 */
class ASEvents extends BlockBase implements BlockPluginInterface {


  /**
   * {@inheritdoc}
   */


  public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['events_shown'])) {
      //1 shows 2, 2 shows 3 etc. so subtract 1
      $events_shown = $config['events_shown'] - 1;
    }
    else {
      $events_shown = 0;
    }
    if (!empty($config['keyword_params'])) {
      $keyword_params = $config['keyword_params'];
    }
    else {
      $keyword_params = "casfeatured";
    }
    $build = [];
    $build['events_block']['#markup'] = "";
    $event_count = 0;
    $event_json = as_events_get_events_json($events_shown,$keyword_params);


    if (!empty($event_json)) {
      foreach($event_json as $event_data) {
        if ($event_count <= $events_shown) {
            $build['events_block']['#markup'] = $build['events_block']['#markup'] . as_events_generate_event_item_markup($event_data);
          $event_count++;
        }

      }

    } // There were no events
    else {
      $build['events_block']['#markup'] = "<main>
                <h1>Events Calendar</h1>
                <p>There are no upcoming events</p>
                </main>";
    }

    return $build;
  }
}
