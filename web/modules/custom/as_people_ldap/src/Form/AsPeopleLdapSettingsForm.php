<?php
namespace Drupal\as_people_ldap\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\MapArray;


class AsPeopleLdapSettingsForm extends ConfigFormBase {

    /**
    *array An array of configuration object names that are editable
	*/
   protected function getEditableConfigNames() {
   return ['as_people_ldap.credentials'];
  }

   public function getFormID() {
    return 'as_people_ldap_settings_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('as_people_ldap.credentials');  //since we are extending ConfigFormBase instead of FormBase, it gives use access to the config object
    $form['ldaprdn'] = array(
      '#type' => 'textfield',
      '#description' => t('ldap rdn or dn'),
      '#title' => t('ldap rdn or dn'),
      '#default_value' => $config->get('ldaprdn'),
    );
    $form['ldappass'] = array(
      '#type' => 'textfield',
      '#description' => t('ldap password'),
      '#title' => t('ldap password'),
      '#default_value' => $config->get('ldappass'),
    );
    return parent::buildForm($form,$form_state);
  }

  /**
   * Form submission handler.
   *
   *  $form -> An associative array containing the structure of the form.
   *  $form_state -> An associative array containing the current state of the form.
   */

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('as_people_ldap.credentials')
      ->set('ldaprdn', $form_state->getValue('ldaprdn'))
      ->set('ldappass', $form_state->getValue('ldappass'))
      ->save();
  }
}
