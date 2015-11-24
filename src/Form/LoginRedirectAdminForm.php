<?php

/**
 * @file
 * Contains \Drupal\login_redirect\Form\LoginRedirectAdminForm.
 */

namespace Drupal\login_redirect\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Login Redirect settings for this site.
 */
class LoginRedirectAdminForm extends ConfigFormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'login_redirect_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Default settings
    $config = $this->config('login_redirect.settings');

    $form['status'] = array(
      '#type' => 'radios',
      '#options' => array(0 => $this->t('Disabled'), 1 => $this->t('Enabled')),
      '#title' => $this->t('Module status'),
      '#default_value' => $config->get('status'),
      '#description' => $this->t('Should the module be enabled?'),
    );

    $form['destination'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Destination'),
      '#default_value' => $config->get('destination'),
      '#maxlength' => 255,
      '#description' => $this->t('Enter user defined query parameter name same as we have q in drupal core. For example if the parameter name is set to "destination", then you would visit user/login&destination=(redirect destination).'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('login_redirect.settings');
    $config->set('status', $form_state->getValue('status'));
    $config->set('destination', $form_state->getValue('destination'));
    $config->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}.
   */
  protected function getEditableConfigNames() {
    return [
      'login_redirect.settings',
    ];
  }

}
