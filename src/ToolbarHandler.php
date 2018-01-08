<?php

namespace Drupal\rebuild_cache_access;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Toolbar integration handler.
 */
class ToolbarHandler implements ContainerInjectionInterface {

  use StringTranslationTrait;

  /**
   * The menu link tree service.
   *
   * @var \Drupal\Core\Menu\MenuLinkTreeInterface
   */
  protected $menuLinkTree;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * ToolbarHandler constructor.
   *
   * @param \Drupal\Core\Menu\MenuLinkTreeInterface    $menu_link_tree
   *   The menu link tree service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The current user.
   */
  public function __construct(MenuLinkTreeInterface $menu_link_tree, ConfigFactoryInterface $config_factory, AccountProxyInterface $account) {
    $this->menuLinkTree = $menu_link_tree;
    $this->account      = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('toolbar.menu_tree'),
      $container->get('config.factory'),
      $container->get('current_user')
    );
  }

  /**
   * Hook bridge.
   *
   * @return array
   *   The devel toolbar items render array.
   *
   * @see hook_toolbar()
   */
  public function toolbar() {

    $items['rebuild_cache_access'] = [
      '#cache' => [
        'contexts' => ['user.permissions'],
      ],
    ];

    if ($this->account->hasPermission('rebuild cache access')) {
      $items['rebuild_cache_access'] += [
        '#type'     => 'toolbar_item',
        '#weight'   => 999,
        'tab'       => [
          '#type'       => 'link',
          '#title'      => $this->t('Rebuild Cache'),
          '#url'        => Url::fromRoute('rebuild_cache_access.rebuild_cache'),
          '#attributes' => [
            'title' => $this->t('Rebuild Cache Access'),
            'class' => ['toolbar-icon', 'toolbar-icon-rebuild-cache-access'],
          ],
        ],
        '#attached' => [
          'library' => 'rebuild_cache_access/rebuild-cache-access-toolbar',
        ],
      ];
    }

    return $items;
  }

}
