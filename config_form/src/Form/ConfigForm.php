<?php

/*
 * @file
 * Contains \Drupal\config_form\Form\ConfigForm.
 *
 */

namespace Drupal\config_form\Form;

use Drupal\config_form\EventDemo;
use Drupal\config_form\MyModuleEvents;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'd8learn_config_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('config_form.form');
    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#required' => TRUE,
      '#default_value' => $config->get('title'),
    );
    $form['video'] = array(
      '#type' => 'textfield',
      '#title' => t('Video'),
      '#default_value' => $config->get('video'),
    );
    $form['develop'] = array(
      '#type' => 'checkbox',
      '#title' => t('This is a checkbox'),
      '#default_value' => $config->get('develop'),
    );
    $form['description'] = array(
      '#type' => 'textarea',
      '#title' => t('Description'),
      '#default_value' => $config->get('description'),
    );
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config(('config_form.form'));

    $config->set('title', $form_state->getValue('title'))
      ->set('video', $form_state->getValue('video'))
      ->set('develop', $form_state->getValue('develop'))
      ->set('description', $form_state->getValue('description'));

    $dispatcher = \Drupal::service('event_dispatcher');

    $event = new EventDemo($config);

    $event = $dispatcher->dispatch(MyModuleEvents::DEMO_SUBMIT_FORM_EVENT, $event);

    $config_data = $event->getConfig()->get();

    $config->merge($config_data);

    $config->save();
  }
  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['config_form.form'];
  }
}