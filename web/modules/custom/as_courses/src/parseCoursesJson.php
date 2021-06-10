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
  public function parse_courses_json($semester,$keyword_params,$courses_shown)
  {
    $course_record = [];
    $instructors = [];
    $course_count = 0;
    //conver from real number to 0 base
    $courses_shown = $courses_shown - 1;
    $courses_json = as_courses_get_courses_json($semester,$keyword_params);
    //dump($courses_json);
    if (!empty($courses_json)) {
      foreach ($courses_json as $course_data) {
        if ($course_count <= $courses_shown) {
          // get instructors as array
          $course_instructors = $course_data['enrollGroups'];
          foreach ($course_instructors as $tempinstructors) {
              $instructors[] = array('firstname' => $tempinstructors['classSections'][0]['meetings'][0]['instructors'][0]['firstName'], 'lastname' => $tempinstructors['classSections'][0]['meetings'][0]['instructors'][0]['lastName'], 'netid' => $tempinstructors['classSections'][0]['meetings'][0]['instructors'][0]['netid']);
              }
          // course record data
          $course_record[] = array('subject' => $course_data['subject'], 'number' => $course_data['catalogNbr'], 'title' => $course_data['titleLong'], 'description' => strip_tags($course_data['description']), 'offered' => $course_data['catalogWhenOffered'], 'acadGroup' => $course_data['acadGroup'], 'acadCareer' => $course_data['acadCareer'], 'instructors' => $instructors);
          $course_count++;
        }
      }
    }
    return $course_record;
  }
}
