<?php

namespace Drupal\as_dept_articles_json;

/**
 * extend Drupal's Twig_Extension class
 */
class parseArticleJson extends \Twig_Extension
{

  /**
   * {@inheritdoc}
   * Let Drupal know the name of custom extension
   */
  public function getName()
  {
    return 'as_dept_articles_json.parse.json';
  }


  /**
   * {@inheritdoc}
   * Return custom twig function to Drupal
   */
  public function getFunctions()
  {
    return [
      new \Twig_SimpleFunction('parse_article_json', [$this, 'parse_article_json']),
    ];
  }

  /**
   * Parses article JSON data into array for theming
   *
   *
   * @return array $article_record
   *   data in array for theming
   */
  public function parse_people_json($pathtoken)
  {
    $article_record = [];
    $departments = '';
    $summary = '';
    $article_json = as_dept_articles_json_get_article_json($pathtoken);
    if (!empty($article_json['data'])) {
      // get image path from json
      //foreach($people_json['included'] as $image) {
      if (!empty($article_json['included'])) {
      $article_record['imagepath'] = 'https://as.cornell.edu' . $people_json['included'][1]['attributes']['uri']['url'];
        }
      //}
      foreach ($article_json['data'] as $article_data) {
        $article_record['alt'] = 'Image from ' . $article_data['attributes']['title'];
        $article_record['uuid'] = $pathtoken;
        $article_record['path'] = $article_data['attributes']['path']['alias'];
        $article_record['title'] = $article_data['attributes']['title'];
        // more fields like byline and media source


        // get department label from json
        foreach ($article_data['relationships']['field_departments_programs']['data'] as $dept_data) {
          $deptuuid = $dept_data['id'];
          $dept_json = as_dept_articles_json_get_dept_json($deptuuid);
          $departments = $departments . $dept_json['data']['attributes']['name'] . ', ';
        }
        $article_record['departments'] = rtrim($departments, ', ');

        // get summary from json
        // adapt for article body
        if (!empty($article_data['relationships']['field_summary']['data'])) {
          foreach ($article_data['relationships']['field_summary']['data'] as $summary_data) {
              $summaryuuid = $summary_data['id'];
              $summary_json = as_dept_articles_json_get_article_body_json($summaryuuid);
              if (!empty($summary_json['data']['attributes']['field_description']['processed'])) {
                $summary = $summary . $summary_json['data']['attributes']['field_description']['processed'];
              }
            }
          if (!empty($summary)) {
            $article_record['summary'] = $summary;
          }

        }
      }
    }

    return $article_record;
  }
}
