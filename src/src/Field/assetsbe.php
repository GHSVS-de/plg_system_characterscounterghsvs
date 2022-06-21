<?php
defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;

class plgSystemCharactersCounterGhsvsFormFieldAssetsBe extends FormField
{
	protected $type = 'assetsbe';

	protected function getInput()
	{
		$min = JDEBUG ? '' : '.min';
		$file = 'plg_system_characterscounterghsvs/backend' . $min . '.css';

		HTMLHelper::_(
			'stylesheet',
			$file,
			[
				//Allow template overrides in css/plg_system_charactercounterghsvs:
				'relative' => true,
				'version' => $min ? 'auto' : time(),
			]
		);

		return '';
	}

	protected function getLabel()
	{
		return '';
	}
}
