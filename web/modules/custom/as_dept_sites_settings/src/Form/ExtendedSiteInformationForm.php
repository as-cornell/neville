<?php

namespace Drupal\as_dept_site_settings\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Path\PathValidatorInterface;
use Drupal\Core\Routing\RequestContext;
use Drupal\path_alias\AliasManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\system\Form\SiteInformationForm;


class ExtendedSiteInformationForm extends SiteInformationForm {



    /**
   * The path alias manager.
   *
   * @var \Drupal\path_alias\AliasManagerInterface
   */
  protected $aliasManager;

  /**
   * The path validator.
   *
   * @var \Drupal\Core\Path\PathValidatorInterface
   */
  protected $pathValidator;

  /**
   * The request context.
   *
   * @var \Drupal\Core\Routing\RequestContext
   */
  protected $requestContext;

  /**
   * Constructs a SiteInformationForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\path_alias\AliasManagerInterface $alias_manager
   *   The path alias manager.
   * @param \Drupal\Core\Path\PathValidatorInterface $path_validator
   *   The path validator.
   * @param \Drupal\Core\Routing\RequestContext $request_context
   *   The request context.
   */
  public function __construct(ConfigFactoryInterface $config_factory, AliasManagerInterface $alias_manager, PathValidatorInterface $path_validator, RequestContext $request_context) {
    parent::__construct($config_factory);
    $this->aliasManager = $alias_manager;
    $this->pathValidator = $path_validator;
    $this->requestContext = $request_context;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('path_alias.manager'),
      $container->get('path.validator'),
      $container->get('router.request_context')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'system_site_information_settings';
  }
    /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['system.site'];
  }
   /**
   * {@inheritdoc}
   */
      public function buildForm(array $form, FormStateInterface $form_state) {
        $site_config = $this->config('system.site');
        $form =  parent::buildForm($form, $form_state);
    $form['other_smack'] = [
      '#type' => 'details',
      '#title' => t('Other Shit'),
      '#open' => TRUE,
    ];
    $form['other_smack']['site_morp'] = [
      '#type' => 'textfield',
      '#title' => t('Site morp'),
      '#default_value' => $site_config->get('morp'),
      '#required' => TRUE,
    ];

        return $form;
    }

      public function submitForm(array &$form, FormStateInterface $form_state) {
        $this->config('system.site')
          ->set('morp', $form_state->getValue('site_morp'))
          ->save();
        parent::submitForm($form, $form_state);
      }
}
