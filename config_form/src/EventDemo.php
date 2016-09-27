<?php

/**
 * @file
 * Contains Drupal\config_form\EventDemo.
 */

namespace Drupal\config_form;

use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Config\Config;

class EventDemo extends Event {

  protected $config;

  /**
   * Constructor.
   *
   * @param Config $config
   */
  public function __construct(Config $config) {
    $this->config = $config;
  }

  /**
   * Getter for the config object.
   *
   * @return Config
   */
  public function getConfig() {
    return $this->config;
  }

  /**
   * Setter for the config object.
   *
   * @param $config
   */
  public function setConfig($config) {
    $this->config = $config;
  }

}