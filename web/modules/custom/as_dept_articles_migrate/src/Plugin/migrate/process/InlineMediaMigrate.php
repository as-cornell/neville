<?php

namespace Drupal\as_dept_migrate_articles\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\file\FileInterface;
use Drupal\migrate\Row;
use Drupal\media\Entity\Media;
use Drupal\Core\Database\Database;
use Drupal\Component\Utility\Unicode;

/**
 * @MigrateProcessPlugin(
 *   id = "image_inline_to_media"
 * )
 */
class InlineMediaMigrate extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($html, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    // Values for the following variables are specified in the YAML file above.
    $images_source = $this->configuration['images_source'];
    $destination = $this->configuration['images_destination'];

    preg_match_all('/<img[^>]+>/i', $html, $result);

    if (!empty($result[0])) {

      foreach ($result as $img_tags) {
        foreach ($img_tags as $img_tag) {

          preg_match_all('/(alt|src)=("[^"]*")/i', $img_tag, $tag_attributes);

          $filepath = str_replace('"', '', $tag_attributes[2][1]);

          if (!empty($tag_attributes[2][1])) {

            // Create file object from a locally copied file.
            $filename = basename($filepath);

            if (file_prepare_directory($destination, FILE_CREATE_DIRECTORY)) {

              if (filter_var($filepath, FILTER_VALIDATE_URL)) {
                $file_contents = file_get_contents($filepath);
              }
              else {
                $file_contents = file_get_contents($images_source . $filepath);
              }
              $new_destination = $destination . '/' . $filename;

              if (!empty($file_contents)) {

                if ($file = file_save_data($file_contents, $new_destination, FILE_EXISTS_REPLACE)) {

                  // Create media entity using saved file.
                  $media = Media::create([
                    'bundle'      => 'image',
                    'uid'         => 1,
                    'langcode'    => 'en',
                    'field_media_image' => [
                      'target_id' => $file->id(),
                      'alt'       =>  !empty($tag_attributes[0][0]) ? Unicode::truncate(substr(str_replace('"', '', $tag_attributes[0][0]), 4), 512) : '',
                    ],
                  ]);

                  $media->save();
                  $uuid = $this->getMediaUuid($file);
                  $html = str_replace($img_tag, '<drupal-entity
                    data-align="left"
                    data-embed-button="media_entity_embed"
                    data-entity-embed-display="view_mode:media.6_4"
                    data-entity-type="media"
                    data-entity-uuid="' . $uuid . '"></drupal-entity>', $html);
                }

              }

            }
          }
        }
      }
    }
    return $html;
  }

  /**
   * Get Media UUID by File ID.
   */
  protected function getMediaUuid(FileInterface $file) {
    $query = db_select('media__field_media_image', 'f', ['target' => 'default']);
    $query->innerJoin('media', 'm', 'm.mid = f.entity_id');
    $query->fields('m', ['uuid']);
    $query->condition('f.field_media_image_target_id', $file->id());
    $uuid = $query->execute()->fetchField();
    return $uuid;
  }

}
