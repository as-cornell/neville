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
  public function parse_article_json($remote_uuid)
  {
    $article_record = [];
    $departments = '';
    $bylines = '';
    $media_sources = '';
    $summary = '';
    $article_components = '';
    $article_json = as_dept_articles_json_get_article_json($remote_uuid);
    if (!empty($article_json['data'])) {
      // get image path from json
      //foreach($people_json['included'] as $image) {
      if (!empty($article_data['relationships']['field_image']['data'])) {
        foreach ($article_data['relationships']['field_image']['data'] as $media_data) {
        $media_id = $media_data['id'];
        $media_type = $media_data['type'];
        $media_json  = as_dept_articles_json_get_image_json($media_id,$media_type);
        if (!empty($media_json['data'])) {
          $article_record['alt'] = $media_json['data']['relationships']['field_media_image']['data']['meta']['alt'];
          $file_uuid = $media_json['data']['relationships']['field_media_image']['data']['id'];
          $file_type = $media_json['data']['relationships']['field_media_image']['data']['type'];
          $file_json = as_dept_articles_json_get_file_json($file_id,$file_type);
            foreach ($file_json['data'] as $file_data) {
              $article_record['imagepath'] = $file_data['attributes']['uri']['url'] ;
            }
            }
          }

        }

      foreach ($article_json['data'] as $article_data) {
        // basic fields
        $article_record['uuid'] = $remote_uuid;
        $article_record['path'] = $article_data['attributes']['path']['alias'];
        $article_record['title'] = $article_data['attributes']['title'];
        $article_record['card_label'] = $article_data['attributes']['field_card_label'];
        $article_record['dateline'] = $article_data['attributes']['field_dateline'];
        $article_record['summary'] = $article_data['attributes']['field_summary'];
        // more reference fields like related articles

        // get byline label from json
        if (!empty($article_data['relationships']['field_byline_reference']['data'])) {
          foreach ($article_data['relationships']['field_byline_reference']['data'] as $term_data) {
            $term_id = $term_data['id'];
            $term_type = $term_data['type'];
            $byline_json = as_dept_articles_json_get_term_json($term_id,$term_type);
            $bylines = $bylines . $byline_json['data']['attributes']['name'] . ', ';
              }
            }
        $article_record['bylines'] = rtrim($bylines, ', ');
        // get media source label from json
        if (!empty($article_data['relationships']['field_media_source_reference']['data'])) {
          foreach ($article_data['relationships']['field_media_source_reference']['data'] as $term_data) {
            $term_id = $term_data['id'];
            $term_type = $term_data['type'];
            $media_source_json = as_dept_articles_json_get_term_json($term_id,$term_type);
            $media_sources = $media_sources . $media_source_json['data']['attributes']['name'] . ', ';
            }
          }
        $article_record['media_sources'] = rtrim($media_sources, ', ');

        // get department label from json
        if (!empty($article_data['relationships']['field_department_program']['data'])) {
            foreach ($article_data['relationships']['field_department_program']['data'] as $term_data) {
              $term_id = $term_data['id'];
              $dept_json = as_dept_articles_json_get_term_json($term_id,$term_type);
              $departments = $departments . $dept_json['data']['attributes']['name'] . ', ';
            }
          }
        $article_record['departments'] = rtrim($departments, ', ');

        // get article body
        if (!empty($article_data['relationships']['field_article_components_entity']['data'])) {
          foreach ($article_data['relationships']['field_article_components_entity']['data'] as $article_component_data) {
            //maybe pass as an array instead of 2 strings
              $article_component_uuid = $article_component_data['id'];
              $article_component_type = $article_component_data['type'];
              $article_component_json = as_dept_articles_json_get_article_body_json($article_component_uuid,$article_component_type);
              if (!empty($article_component_json['data']['attributes']['field_formatted_text']['processed'])) {
                $article_components = $article_components . $article_component_json['data']['attributes']['field_formatted_text']['processed'];
              }
            }
          if (!empty($article_components)) {
            $article_record['article_components'] = $article_components;
          }

        }
      }
    }

    return $article_record;
  }
}
