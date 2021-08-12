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
      if (!empty($article_json['included'][0])) {
        if ($article_json['included'][0]['type'] == 'media--image') {
      $article_record['imagealt'] = $article_json['included'][0]['relationships']['field_media_image']['data']['meta']['alt'];
          }
        }
      if (!empty($article_json['included'][1])) {
        if ($article_json['included'][1]['type'] == 'file--file') {
          if (!empty($article_json['included'][1]['attributes']['image_style_uri'][1]['4_5'])) {
            $article_record['imagepath'] = $article_json['included'][1]['attributes']['image_style_uri'][1]['4_5'];
          }else{
            $article_record['imagepath'] = 'https://as.cornell.edu/sites/default/files/field/image/Klarmanarticle.jpg';
            }
            if (!empty($article_json['included'][1]['attributes']['image_style_uri'][2]['6_4_newsletter'])) {
            $article_record['newsletter_imagepath'] = $article_json['included'][1]['attributes']['image_style_uri'][2]['6_4_newsletter'];
          }else{
            $article_record['newsletter_imagepath'] = 'https://as.cornell.edu/sites/default/files/styles/6_4_large/public/field/image/0824_cnf1_450x517px.jpg';
            }
            if (!empty($article_json['included'][1]['attributes']['image_style_uri'][0]['1_1_thumbnail_forced'])) {
            $article_record['newsletter_imagepath'] = $article_json['included'][1]['attributes']['image_style_uri'][0]['1_1_thumbnail_forced'];
          }else{
            $article_record['newsletter_imagepath'] = 'https://as.cornell.edu/sites/default/files/styles/6_4_large/public/field/image/0824_cnf1_450x517px.jpg';
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
        // related departments programs are now coming from departments programs relationship on node
        // get department label from json
        //if (!empty($article_data['relationships']['field_department_program']['data'])) {
            //foreach ($article_data['relationships']['field_department_program']['data'] as $term_data) {
              //$term_id = $term_data['id'];
              //$dept_json = as_dept_articles_json_get_term_json($term_id,$term_type);
              //$departments = $departments . $dept_json['data']['attributes']['name'] . ', ';
            //}
          //}
        //$article_record['departments'] = rtrim($departments, ', ');
        // related articles are now coming from relared articles field on node
        // get related article title, link, and thumbnail from json
        //if (!empty($article_data['relationships']['field_related_articles'])) {
            //foreach ($article_data['relationships']['field_related_articles']['data'] as $key => $related_article_data) {
              //$article_id = $related_article_data['id'];
              //$related_articles_json = as_dept_articles_json_get_article_json($article_id);
                //foreach ($related_articles_json['data'] as $related_article_json) {
                    //$related_articles[$key] = [
                      //'#title' => $related_article_json['attributes']['title'],
                      //'#alias' => 'https://as.cornell.edu' .$related_article_json['attributes']['path']['alias']
                    //];
                  //foreach ($related_articles_json['included'] as $related_article_image_json) {
                  //if ($related_article_image_json['type'] =='file--file') {

                    //$related_articles[$key]['image']['#uri'] = 'https://as.cornell.edu' . $related_article_image_json['attributes']['uri']['url'];
                   // }
                  //if ($related_article_image_json['type'] =='media--image') {

                    //$related_articles[$key]['image']['#alt'] = $related_article_image_json['relationships']['field_media_image']['data']['meta']['alt'];
                    //}
                 // }
                //}
            //}

          //}

        //$article_record['related_articles']= $related_articles;
        // related people are now coming from people node relationship on node
        // get related people title, link, and thumbnail from json
        //if (!empty($article_data['relationships']['field_related_people'])) {
            //foreach ($article_data['relationships']['field_related_people']['data'] as $key => $related_people_data) {
              //$person_uuid = $related_people_data['id'];
              //if (!empty($person_uuid)) {
              //$related_people_json = as_dept_articles_json_get_person_json($person_uuid);
              //if (!empty($related_people_json)) {
                //foreach ($related_people_json['data'] as $related_person_json) {
                    //$related_people[$key] = [
                      //'#title' => $related_person_json['attributes']['title'],
                      //'#alias' => 'https://as.cornell.edu/people' .$related_person_json['attributes']['path']['alias']
                    //];
                  //foreach ($related_people_json['included'] as $related_person_image_json) {
                  //if ($related_person_image_json['type'] =='file--file') {
                    //$related_people[$key]['image']['#uri'] = 'https://people.as.cornell.edu' . $related_person_image_json['attributes']['uri']['url'];
                    //}
                  //if ($related_person_image_json['type'] =='media--image') {
                    //$related_people[$key]['image']['#alt'] = $related_person_image_json['relationships']['field_media_image']['data']['meta']['alt'];
                   // }
                  //}
                 //}
                //}
                //}
            //}

          //}
        //$article_record['related_people'] = $related_people;

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
