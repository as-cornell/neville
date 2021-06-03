<?php

namespace Drupal\as_dept_people_json;

/**
 * extend Drupal's Twig_Extension class
 */
class parsePeopleJson extends \Twig_Extension
{

  /**
   * {@inheritdoc}
   * Let Drupal know the name of custom extension
   */
  public function getName()
  {
    return 'as_dept_people_json.parse.json';
  }


  /**
   * {@inheritdoc}
   * Return custom twig function to Drupal
   */
  public function getFunctions()
  {
    return [
      new \Twig_SimpleFunction('parse_people_json', [$this, 'parse_people_json']),
    ];
  }

  /**
   * Parses person JSON data into array for theming
   *
   * @param string $netid
   *   person netid passed from field in twig template
   *
   * @return array $person_record
   *   data in array for theming
   */
  public function parse_people_json($pathtoken)
  {
    $person_record = [];
    $departments = '';
    $articles = '';
    $summary = '';
    $researchfocus = '';
    $people_json = as_dept_people_json_get_person_json($pathtoken);
    if (!empty($people_json['data'])) {
      // get image path from json
      //foreach($people_json['included'] as $image) {
      if (!empty($people_json['included'])) {
      $person_record['imagepath'] = $people_json['included'][1]['attributes']['image_style_uri'][0]['person_image'];
        }
      //}
      foreach ($people_json['data'] as $person_data) {
        $person_record['alt'] = 'Image of ' . $person_data['attributes']['title'];
        $person_record['netid'] = $person_data['attributes']['field_person_netid'];
        $person_record['uuid'] = $pathtoken;
        $person_record['path'] = $person_data['attributes']['path']['alias'];
        $person_record['title'] = $person_data['attributes']['title'];
        $person_record['jobtitle'] = $person_data['attributes']['field_person_title'];
        if (!empty($person_data['attributes']['field_responsibilities']['value'])) {
          $person_record['responsibilities'] = $person_data['attributes']['field_responsibilities']['value'];
          }
        if (!empty($person_data['attributes']['field_keywords']['value'])) {
          $person_record['keywords'] = strip_tags($person_data['attributes']['field_keywords']['value']);
          }
        if (!empty($person_data['attributes']['field_person_education']['value'])) {
          $person_record['education'] =$person_data['attributes']['field_person_education']['value'];
          }
        if (!empty($person_data['attributes']['field_person_publications']['value'])) {
          $person_record['publications'] = $person_data['attributes']['field_person_publications']['value'];
          }
        if (!empty($person_data['attributes']['field_links'])) {
          $person_record['links'] = $person_data['attributes']['field_links'];
          }
        // get department label from json
        foreach ($person_data['relationships']['field_departments_programs']['data'] as $dept_data) {
          $deptuuid = $dept_data['id'];
          $dept_json = as_dept_people_json_get_dept_json($deptuuid);
          $departments = $departments . $dept_json['data']['attributes']['name'] . ', ';
        }
        $person_record['departments'] = rtrim($departments, ', ');
        // get list of articles from as.cornell.edu
          //$articles_json = as_dept_people_json_get_people_articles_json($pathtoken);
          //dump($articles_json);
          //$articles = $articles . $articles_json['data']['attributes']['name'] . ', ';
          //foreach ($articles_json as $article) {
            //$articles = $articles . '<li><a href="'.$article['link'].'">'.$article['title'].'</a> - ('.$article['dateline'].')</li>';

          //}
        //print '<ul>'.$articles.'</ul>';
        //$person_record['related_articles'] = $articles;




        // get summary from json
        if (!empty($person_data['relationships']['field_summary']['data'])) {
          foreach ($person_data['relationships']['field_summary']['data'] as $summary_data) {
              $summaryuuid = $summary_data['id'];
              $summary_json = as_dept_people_json_get_people_summary_json($summaryuuid);
              if (!empty($summary_json['data']['attributes']['field_description']['processed'])) {
                $summary = $summary . $summary_json['data']['attributes']['field_description']['processed'];
              }
              if (!empty($summary_json['data']['attributes']['field_person_research_focus']['processed'])) {
                $researchfocus = $researchfocus . $summary_json['data']['attributes']['field_person_research_focus']['processed'];
              }
            }
          if (!empty($summary)) {
            $person_record['summary'] = $summary;
          }
          if (!empty($researchfocus)) {
            $person_record['researchfocus'] = $researchfocus;
          }
        }
      }
    }

    return $person_record;
  }
}
