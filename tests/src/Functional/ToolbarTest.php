<?php

namespace Drupal\Tests\rebuild_cache_access\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests rebuild_cache_access toolbar functionality.
 *
 * @group rebuild_cache_access
 */
class ToolbarTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['toolbar', 'rebuild_cache_access'];

  /**
   * Tests that the necessary route works.
   */
  public function testRoute() {

    $this->drupalGet('rebuild-cache-access/rebuild-cache');
    $this->assertSession()->statusCodeEquals(403);

    $account = $this->drupalCreateUser(['rebuild cache access']);
    $this->drupalLogin($account);

    $this->drupalGet('rebuild-cache-access/rebuild-cache');
    $this->assertSession()->statusCodeEquals(200);
  }

  /**
   * Tests that the toolbar button works.
   */
  public function testButton() {

    $account = $this->drupalCreateUser([
      'access toolbar',
      'rebuild cache access',
    ]);
    $this->drupalLogin($account);

    $this->drupalGet('');
    $this->assertSession()->pageTextContains('Rebuild Cache');
  }
}
