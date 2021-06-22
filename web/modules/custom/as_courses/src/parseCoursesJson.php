<?php

namespace Drupal\as_courses;

/**
 * extend Drupal's Twig_Extension class
 */
class parseCoursesJson extends \Twig_Extension
{

  /**
   * {@inheritdoc}
   * Let Drupal know the name of custom extension
   */
  public function getName()
  {
    return 'as_courses.parse.json';
  }


  /**
   * {@inheritdoc}
   * Return custom twig function to Drupal
   */
  public function getFunctions()
  {
    return [
      new \Twig_SimpleFunction('parse_courses_json', [$this, 'parse_courses_json']),
    ];
  }

  /**
   * Parses courses JSON data into array for theming
   *
   *
   * @return array $course_record
   *   data in array for theming
   */
  public function parse_courses_json($semester,$keyword_params,$courses_shown,$list_order)
  {
    $course_record = [];

    //convert from real number to 0 base
    if (!empty($courses_shown)) {
    $courses_shown = $courses_shown - 1;
    $course_count = 0;
    }

    $courses_json = as_courses_get_courses_json($semester,$keyword_params);
    //dump($courses_json);
    //multiple random courses with shuffle()
    //https://www.w3schools.com/php/func_array_shuffle.asp
    if ($list_order == 'random'){
      shuffle($courses_json);
      }
    if (!empty($courses_json)) {
      foreach ($courses_json as $course_data) {
        if (!empty($courses_shown) &&  $course_count <= $courses_shown) {
          // get a certain number of courses
          $course_record[] = array('subject' => $course_data['subject'], 'number' => $course_data['catalogNbr'], 'title' => $course_data['titleLong'], 'description' => strip_tags($course_data['description']), 'offered' => $course_data['catalogWhenOffered'], 'acadGroup' => $course_data['acadGroup'], 'acadCareer' => $course_data['acadCareer']);
          $course_count++;
        }
        if (empty($courses_shown)) {
          // get all courses
          $course_record[] = array('subject' => $course_data['subject'], 'number' => $course_data['catalogNbr'], 'title' => $course_data['titleLong'], 'description' => strip_tags($course_data['description']), 'offered' => $course_data['catalogWhenOffered'], 'acadGroup' => $course_data['acadGroup'], 'acadCareer' => $course_data['acadCareer']);
        }
      }
    }
    return $course_record;
  }
}
