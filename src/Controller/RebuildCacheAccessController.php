<?php

namespace Drupal\rebuild_cache_access\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Returns responses for rebuild_cache_access module routes.
 */
class RebuildCacheAccessController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function __construct(RequestStack $request_stack) {
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack')
    );
  }

  /**
   * Reload the previous page.
   */
  public function reloadPage() {
    $request = $this->requestStack->getCurrentRequest();
    if ($request->server->get('HTTP_REFERER')) {
      return $request->server->get('HTTP_REFERER');
    }
    else {
      return '/';
    }
  }

  /**
   * Rebuild all caches, then redirects to the previous page.
   */
  public function rebuildCache() {
    drupal_flush_all_caches();
    drupal_set_message($this->t('All caches cleared.'));
    return new RedirectResponse($this->reloadPage());
  }

}
