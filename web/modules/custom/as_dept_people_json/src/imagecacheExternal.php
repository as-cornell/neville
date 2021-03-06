<?php

namespace Drupal\as_dept_people_json;


use Drupal\image\Entity\ImageStyle;

/**
 * Class ImagecacheExternal.
 */
class imagecacheExternal extends \Twig_Extension {


  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    return [
      new \Twig_SimpleFilter('imagecache_external', [
        $this,
        'imageCacheExternal',
      ]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'as_dept_people_json.imagecache.external';
  }

  /**
   * Returns the URL of this image derivative for an original image path or URI.
   *
   * Example:
   *
   * @code
   *  {{ 'https://my.web.site/my-image.jpg'|imagecache_external('thumbnail') }}
   * @endcode
   *
   * @param string $path
   *   The path or URI to the original image.
   * @param string $style
   *   The image style.
   *
   * @return string|null
   *   The absolute URL where a style image can be downloaded, suitable for use
   *   in an <img> tag. Requesting the URL will cause the image to be created.
   */
  public function imageCacheExternal($path, $style) {
    $local_path = imagecache_external_generate_path($path);

    if (!$image_style = ImageStyle::load($style)) {
      trigger_error(sprintf('Could not load image style %s.', $style));
      return;
    }

    if (!$image_style->supportsUri($local_path)) {
      trigger_error(sprintf('Could not apply image style %s.', $style));
      return;
    }

    return file_url_transform_relative($image_style->buildUrl($local_path));
  }

}

?>
