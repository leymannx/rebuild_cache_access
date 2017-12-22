<?php

namespace Drupal\rebuild_cache_access\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for rebuild_cache_access module routes.
 */
class RebuildCacheAccessController extends ControllerBase {

  /**
   * Rebuild all caches, then redirects to the previous page.
   */
  public function rebuildCache() {
    drupal_flush_all_caches();
    drupal_set_message('Cache cleared.');
    return $this->redirect('<front>');
  }

}
