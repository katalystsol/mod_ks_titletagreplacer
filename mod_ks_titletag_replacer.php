<?php
/**
 * @package     Joomla
 * @subpackage  Content
 *
 * @copyright   Copyright Katalyst Solutions, LLC
 * @license     Commercial
 * @since 1.0
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once dirname(__FILE__).'/helper.php';

$defaultTitle = $params->get('default_title', null);

$helper = new ModKSTitleTagReplacerHelper($defaultTitle);

$title = $helper->getTitle();

if ($params->def('prepare_content', 1))
{
	JPluginHelper::importPlugin('content');
	$module->content = JHtml::_('content.prepare', $module->content, '', 'mod_ks_titletag_replacer.content');
}

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
$moduleBackground_image = $params->get('backgroundimage') ?
	' style="background-image:url(' . $params->get('backgroundimage') . ')"' :
	'';

$module->content = str_replace('[title]', $title, $module->content);

require JModuleHelper::getLayoutPath('mod_ks_titletag_replacer', $params->get('layout', 'default'));
