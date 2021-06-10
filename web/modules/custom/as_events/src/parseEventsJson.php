<?php

namespace Drupal\as_events;

/**
 * extend Drupal's Twig_Extension class
 */
class parseEventsJson extends \Twig_Extension
{

  /**
   * {@inheritdoc}
   * Let Drupal know the name of custom extension
   */
  public function getName()
  {
    return 'as_events.parse.json';
  }


  /**
   * {@inheritdoc}
   * Return custom twig function to Drupal
   */
  public function getFunctions()
  {
    return [
      new \Twig_SimpleFunction('parse_events_json', [$this, 'parse_events_json']),
    ];
  }

  /**
   * Parses events JSON data into array for theming
   *
   *
   * @return array $event_record
   *   data in array for theming
   */
  public function parse_events_json($events_shown,$keyword_params)
  {
    $event_record = [];
    $event_count = 0;
    $events_json = as_events_get_events_json($events_shown,$keyword_params);
    //dump($events_json);
    if (!empty($events_json)) {
      foreach ($events_json as $event_data) {
        //dump($event_data);
        //convert from real number to 0 base
        //$events_shown = $events_shown - 1;
        if ($event_count <= $events_shown) {
          // event record data
          //dates and times
          $event_start_date = date_create($event_data['event']['event_instances'][0]['event_instance']['start']);
          if (!empty($event_data['event']['event_instances'][0]['event_instance']['end'])) {
            $event_end_date = date_create($event_data['event']['event_instances'][0]['event_instance']['end']);
          } else {
            $event_end_date = NULL;
          }
          $event_formatted_date = as_events_format_event_dates($event_start_date, $event_end_date);
          if (!empty($event_data['event']['location_name'])){
            $location = $event_data['event']['location_name'];
          }else{
            $location = 'n/a';
          }
          if (!empty($event_data['event']['location_name'])){
            $room = $event_data['event']['room_number'];
          }else{
            $room = 'n/a';
          }
          $event_record[] = array('title' => $event_data['event']['title'], 'url' => $event_data['event']['localist_url'], 'location' => $location, 'room' => $room, 'description' => strip_tags($event_data['event']['description']), 'image' => $event_data['event']['photo_url'], 'month' => $event_formatted_date['start_month'], 'date' => $event_formatted_date['start_date']);
          $event_count++;
        }
      }
    }
    return $event_record;
  }
}
