<?php
defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;

class plgSystemCharactersCounterGhsvsFormFieldAssetsBe extends FormField
{
	protected $type = 'assetsbe';

	protected function getInput()
	{
		$file = 'plg_system_characterscounterghsvs/backend.css';

		HTMLHelper::_('stylesheet',
			$file,
			array(
				//Allow template overrides in css/plg_system_charactercounterghsvs:
				'relative' => true,
				//'pathOnly' => false,
				//'detectBrowser' => false,
				//'detectDebug' => true,
			)
		);
		return '';
	}
	
	protected function getLabel()
	{
		return '';
	}
}
