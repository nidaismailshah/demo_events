<?php

namespace Drupal\event_demo\EventSubscriber;

use Drupal\config_form\EventDemo;
use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use \Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use \Symfony\Component\HttpKernel\KernelEvents;
use Drupal\config_form\MyModuleEvents;

class AlterResponse implements EventSubscriberInterface {


  protected $logger;

  /**
   * AlterResponse constructor.
   */
  public function __construct(LoggerChannelFactoryInterface $logger) {
    $this->logger = $logger;
  }

  public function loggingDemo(GetResponseEvent $event) {
    $path = $event->getRequest()->getPathInfo();

    //$logger = \Drupal::getContainer()->get('logger.factory');

    // Log the path of the page visited.
    $this->logger->get('default')->debug($path . ' was visited just now');
  }

  public function doSomething(ConfigCrudEvent $event) {
    // Do something.
  }
  
  public function alterConfig(EventDemo $event) {
    $config = $event->getConfig();

    $video = "I wont show, really? yes i was altered";
    $config->set('video', $video);
    
  }

  public function alterConfigAgain(EventDemo $event) {
    $config = $event->getConfig();

    $video = "Am I still a video? previous value";
    $config->set('video', $video);

  }
  public function demoResponse(FilterResponseEvent $event) {
    $response  = $event->getResponse();
    $response->setContent("This is coming from an Event subscriber . coming from subscriber");
  }

  public static function getSubscribedEvents() {
    return [
      //KernelEvents::RESPONSE => 'demoResponse'
      //KernelEvents::REQUEST => 'loggingDemo',
      //ConfigEvents::SAVE => ['doSomething', 999],
      //'event_demo.form' => ['alterConfig', 0],
      MyModuleEvents::DEMO_SUBMIT_FORM_EVENT => [
        ['alterConfig', 10],
        ['alterConfigAgain', 0],
      ],
    ];
  }

}