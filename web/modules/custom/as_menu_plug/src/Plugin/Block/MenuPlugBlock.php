<?php

namespace Drupal\as_menu_plug\Plugin\Block;

use Drupal\Core\Block\BlockBase;
//use Drupal\Core\Form\FormStateInterface;
//use Drupal\node\Entity\Node;

/**
 * Provides a 'MenuPlugBlock' block.
 *
 * @Block(
 *  id = "menu_plug_block",
 *  admin_label = @Translation("Menu Plug block"),
 * )
 */
class MenuPlugBlock extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $build = [];
    //$build['#theme'] = 'menu_plug_block';
    $build['menu_plug_block']['#markup'] = '';
    $menu_link_id = '';
    $entity_id = '';
    $menu_level = '';
    $link_class = '';
    $list_class = '';
    $config = $this->getConfiguration();
    if (!empty($config['menu_link_id'])) {
      $menu_link_id = $config['menu_link_id'];
    }
    if (!empty($config['menu_level'])) {
      $menu_level = $config['menu_level'];
    }
    // get link class
    $link_class = as_menu_plug_generate_link_class($menu_level);
    // get link class
    $list_class = as_menu_plug_generate_list_class($menu_level);
    // get $nid from $menu_link_id uri
    $entity_id = as_menu_plug_menulinkid_nid($menu_link_id);
    // strip $nid
    $nid = as_menu_plug_strip_id($entity_id);
    // get node alias
    $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/' . $nid);
    // load node
    if (!empty($nid)) {
      $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
      $typeName = $node->bundle();
    }
    // check for node type
    if ($typeName == 'page') {
      //get field values
      if (!empty($node->field_page_components)) {
        $fpce = $node->field_page_components;
      }

      // get page components
      if (!empty($fpce)) {
        $index = 0;
        // make sure we need a wrapper

        // RTM 8/17 hiding the list with inpage navs from big view added otpNav as they can both be the same just visually hidden in sidebar.

        //if (!empty($node->field_page_components[0]->entity->field_page_section_title[0])) {
        $build['menu_plug_block']['#markup'] = $build['menu_plug_block']['#markup'] . '<ul class="' . $list_class . ' otpNav">';
        foreach ($fpce as $pce) {
          // this uses the component entity label as the link text
          //$link_title = $node->field_page_components_entity[$index]->entity->label();
          // this uses only field_page_section_title from a page section entity
          if (!empty($node->field_page_components[$index]->entity->field_page_section_title[0])) {
            $link_title = $node->field_page_components[$index]->entity->field_page_section_title[0]->value;
            $build['menu_plug_block']['#markup'] = $build['menu_plug_block']['#markup'] .  as_menu_plug_generate_link_markup($link_title, $alias, $link_class);
          }
          $index++;
        }
        //if (empty($menu_children)){
        $build['menu_plug_block']['#markup'] = $build['menu_plug_block']['#markup'] . '</ul>';
      }
      //}
    }


    return $build;
  }
}
