<?php

namespace Drupal\event_demo\Controller;

use Drupal\Core\Controller\ControllerBase;

class demoController extends ControllerBase {

  public function content() {
    return [
      '#markup' => '<p> I am a render array.</p>',
    ];
  }
}

