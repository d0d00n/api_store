<?php

namespace Drupal\api_store\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class ApiStoreSettingsForm extends ConfigFormBase {
    /** @var string Config settings */
  const SETTINGS = 'api_store.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'api_store_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['listing_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Listing endpoint (ex: homepage)'),
      '#default_value' => $config->get('listing_endpoint'),
    ];

    $form['subscriptions_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Subscriptions endpoint'),
      '#default_value' => $config->get('subscriptions_endpoint'),
    ];

    $form['logout_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Logout endpoint'),
      '#default_value' => $config->get('logout_endpoint'),
    ];

    $form['replicate_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Replicate endpoint'),
      '#default_value' => $config->get('replicate_endpoint'),
    ];

    $form['sandbox_listing_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Sandbox listing endpoint (to test changes to integration module)'),
      '#default_value' => $config->get('sandbox_listing_endpoint'),
    ];

    $form['sandbox_subscriptions_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Sandbox subscriptions endpoint (to test changes to integration module)'),
      '#default_value' => $config->get('sandbox_subscriptions_endpoint'),
    ];	
	
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
      // Retrieve the configuration
       $this->configFactory->getEditable(static::SETTINGS)
      // Set the submitted configuration setting
      ->set('listing_endpoint', $form_state->getValue('listing_endpoint'))
      ->set('subscriptions_endpoint', $form_state->getValue('subscriptions_endpoint'))
      ->set('logout_endpoint', $form_state->getValue('logout_endpoint'))
      ->set('replicate_endpoint', $form_state->getValue('replicate_endpoint'))
	  ->set('sandbox_listing_endpoint', $form_state->getValue('sandbox_listing_endpoint'))
	  ->set('sandbox_subscriptions_endpoint', $form_state->getValue('sandbox_subscriptions_endpoint'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
