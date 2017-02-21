<?php
/**
 * @package     Joomla
 * @subpackage
 *
 * @copyright   Katalyst Solutions, LLC
 * @license     GPL2
 * @since 1.0
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


class ModKSTitleTagReplacerHelper
{
	protected $app;

	protected $defaultTitle;

	protected $doc;

	protected $menu;

	protected $option;

	/**
	 * ModKSTitleTagReplacerHelper constructor.
	 * @param string $defaultTitle
	 * @since 1.0
	 */
	public function __construct($defaultTitle = null)
	{
		$this->app = JFactory::getApplication();
		$this->doc = JFactory::getDocument();
		$this->option = $this->app->input->getCmd('option', '');
		$this->defaultTitle = $defaultTitle;
	}

	/**
	 * Get the title string
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	public function getTitle()
	{
		if ($this->option == 'com_content') {
			return $this->getArticleTitle();
		}

		return $this->getDefaultTitle();
	}

	/**
	 * Get the title of the article if com_content
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	protected function getArticleTitle()
	{
		$id = $this->app->input->getInt('id', 0);

		if (empty($id)) {
			return $this->getDefaultTitle();
		}

		$article	= JTable::getInstance('content');
		$article->load($id);

		return $article->get('title');
	}

	/**
	 * Return the defaultTitle from the module parameter
	 *
	 * @return null|string
	 *
	 * @since version
	 */
	protected function getDefaultTitle()
	{
		if (!empty($this->defaultTitle)) {
			return $this->defaultTitle;
		}

		return $this->getMenuTitle();
	}

	/**
	 * Get the menu item title
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	protected function getMenuTitle()
	{
		$menu = $this->app->getMenu();
		$activeMenu = $menu->getActive();

		if (empty($activeMenu)) {
			return $this->getSiteTitle();
		}

		return $activeMenu->title;
	}

	/**
	 * Get the site title from global configuration
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	protected function getSiteTitle()
	{
		return $this->doc->title;
	}
}