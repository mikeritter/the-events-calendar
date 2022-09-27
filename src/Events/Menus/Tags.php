<?php

/**
 * Admin Tags menu/page for TEC plugins.
 *
 * @since TBD
 *
 * @package TEC\Events\Menus
 */

namespace TEC\Events\Menus;

use TEC\Common\Menus\Abstract_Menu;
use TEC\Common\Menus\Traits\Submenu;
use TEC\Common\Menus\Traits\Taxonomy;
use Tribe__Events__Main;

/**
 * Class Add_Ons admin/menu.
 *
 * @since TBD
 *
 * @package TEC\Events\Menus
 */
class Tags extends Abstract_Menu {
	use Submenu, Taxonomy;

	/**
	 * {@inheritDoc}
	 */
	protected $capability = 'edit_tribe_events';

	/**
	 * {@inheritDoc}
	 */
	protected $position = 20;


	/**
	 * {@inheritDoc}
	 */
	public function init() : void {
		$this->menu_title   = _x( 'Tags', 'The title for the admin menu link', 'the-events-calendar');
		$this->page_title   = _x( 'Tags', 'The title for the admin page', 'the-events-calendar');
		$this->parent_file  = 'tec-events';
		$this->parent_slug  = 'tec-events';
		$this->tax_slug = 'post_tag';
		$this->post_type = Tribe__Events__Main::POSTTYPE;

		parent::init();
	}
}
