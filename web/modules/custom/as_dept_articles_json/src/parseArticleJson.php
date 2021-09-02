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
    $related_articles = [];
    $related_people = [];
    $article_json = as_dept_articles_json_get_article_json($remote_uuid);
    if (!empty($article_json['data'])) {
      // get image path and alt tag from json
      if (!empty($article_json['included'][0]['relationships']['field_media_image']['data']['meta']['alt'])) {
        if ($article_json['included'][0]['type'] == 'media--image') {
      $article_record['imagealt'] = $article_json['included'][0]['relationships']['field_media_image']['data']['meta']['alt'];
          }
        }
      //dump($article_json['included']);
      if (!empty($article_json['included'][1])) {
        if ($article_json['included'][1]['type'] == 'file--file') {
          if (!empty($article_json['included'][1]['attributes']['filename'])) {
            $article_record['imagepath'] = 'https://as.cornell.edu/sites/default/files/styles/4_5/public/field/image/'.$article_json['included'][1]['attributes']['filename'];
            $article_record['thumbnail_imagepath'] = 'https://as.cornell.edu/sites/default/files/styles/1_1_thumbnail_forced/public/field/image/'.$article_json['included'][1]['attributes']['filename'];

          }else{
            $article_record['imagepath'] = 'https://as.cornell.edu/sites/default/files/styles/4_5/public/field/image/Klarmanarticle.jpg';
            $article_record['thumbnail_imagepath'] = 'https://as.cornell.edu/sites/default/files/styles/1_1_thumbnail_forced/public/field/image/Klarmanarticle.jpg';
            }
          }
      if (!empty($article_json['included'][3])) {
        if ($article_json['included'][3]['type'] == 'file--file') {
          if (!empty($article_json['included'][3]['attributes']['filename'])) {
            $article_record['newsletter_imagepath'] = 'https://as.cornell.edu/sites/default/files/styles/6_4_newsletter/public/field/image/'.$article_json['included'][3]['attributes']['filename'];

          }else{
            $article_record['newsletter_imagepath'] = 'https://as.cornell.edu/sites/default/files/styles/6_4_newsletter/public/field/image/Klarmanarticle.jpg';
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
