<?php
/*
GHSVS 2019-01-10
Usage:
<field name="LongDescription001" 
		type="plgSystemCharactersCounterGhsvs.longdescription"
		hidden="true"
		additionalClass="optional irgendwas"
		descriptiontext="PLG_SYSTEM_CHARACTERSCOUNTERGHSVS_XML_DESCRIPTION_LONG"/>
*/

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

class plgSystemCharactersCounterGhsvsFormFieldLongDescription extends FormField
{
	protected $type = 'longdesription';

	protected function getInput()
	{
		$additionalClass = $this->element['additionalClass'] ?? '';
		
		return '<div class="longdesription descriptiontext ' . $additionalClass . '">' . Text::_($this->element['descriptiontext']) . '</div>';
	}

}
