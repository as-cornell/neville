<?php

use Symfony\Component\Yaml\Yaml;

/**
 * Implements hook_install().
 */
function as_people_stub_install() {
  // Don't do anything during config sync.
  if (\Drupal::isConfigSyncing()) {
    return;
  }
  $overridden_config = [
  ];

  $config_path = \Drupal::root() . '/' . drupal_get_path('module', 'as_people_stub') . '/config/optional/';

  foreach ($overridden_config as $config) {
    $editable_config = Drupal::configFactory()->getEditable($config);
    $new_config_file = $config_path . $config . '.yml';
    $new_config_content = file_get_contents($new_config_file);
    $new_config = (array) Yaml::parse($new_config_content);
    // Check for existing uuid on the config
    if ($uuid = $editable_config->get('uuid')) {
      $new_config['uuid'] = $uuid;
    }
    $editable_config->setData($new_config)->save();
  }
}
