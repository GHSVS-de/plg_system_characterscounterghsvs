<?php
defined('_JEXEC') or die;

#use Joomla\CMS\Authentication\Authentication;
#use Joomla\CMS\Date\Date;
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Form\Form;
#use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
#use Joomla\CMS\Log\Log;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Registry\Registry;
#use Joomla\Utilities\ArrayHelper;
#use Joomla\CMS\User\User;
#use Joomla\CMS\User\UserHelper;


class PlgSystemCharacterscounterghsvs extends CMSPlugin
{
	protected $app;
	#protected $autoloadLanguage = true;
	
	// User can enter custom labels in plugin.
	protected $labelFields = array(
		'charsTypedLabel',
		'charsRemainLabel',
		'charsMaxLabel'
	);
	protected $labelFieldsChecked = null;
	
	function __construct(&$subject, $config = array())
	{
		parent::__construct($subject, $config);

		HTMLHelper::addIncludePath(__DIR__ . '/html');
		#FormHelper::addFieldPath(__DIR__ . '/fields');
	}
	public function onExtensionBeforeSave($context, $table, $isNew, $data = array())
	{
		// Sanitize subform fields.
		if (
			$this->app->isClient('administrator')
			&& $context == 'com_plugins.plugin'
			&& !empty($table->params) && is_string($table->params)
			&& strpos($table->params, '"characterscounterghsvsplugin":"1"') !== false
			&& $table->enabled
		){
			$this->filter = InputFilter::getInstance();
			$params = new Registry($table->params);
			$subform = $params->get('wheres');

			#$log = PHP_EOL . ' $subform before ' . var_export($subform, true) . PHP_EOL;
			#file_put_contents(JPATH_SITE . '/tmp/counters.txt', $log);

			if (empty($subform) || !is_object($subform))
			{
				return;
			}
			
			$cleans = array(
				'note' => 'string',
				'client' => 'string',
				'context' => 'string',
				'target' => 'string',
				'active' => 'integer',
				'chopText' => 'integer',
				'maxChars' => 'integer',
			);
			
			foreach ($subform as $key => $item)
			{
				foreach ($item as $property => $value)
				{
					if (array_key_exists($property, $cleans))
					{
						$subform->$key->$property = $this->filter->clean($value, $cleans[$property]);
					}
					else
					{
						$subform->$key->$property = $this->filter->clean($value, 'string');
					}
				}
			}
			
			$params->set('wheres', $subform);
			
			$table->params = $params->toString();
			
			#$log = PHP_EOL . ' $subform after ' . var_export($subform, true) . PHP_EOL;
			#file_put_contents(JPATH_SITE . '/tmp/counters.txt', $log, FILE_APPEND);
		}
	}
	public function onContentPrepareForm(Form $form, $data)
	{
		$jinput = $this->app->input;
		$layout = $jinput->get('layout', '');
		
		if ($layout !== 'edit')
		{
			return;
		}

		if (!$this->app->isClient('administrator'))
		{
			return;
		}
		
		$context = $form->getName();

##########Simple
		
		// e.g. com_categories.categorycom_content.
		if (strpos($context, 'com_categories.categorycom_', 0) !== false)
		{
			$context = 'com_categories.category';
		}
		
		// Create name of FIELDS tag in form XML. E.g. "com_content:article|edit"
		$fieldsName = str_replace('.', ':', $context) . '|' . $layout;
		
		// Get object of jobs.
		$simpleJobs = $this->params->get($fieldsName);
		
		// Build counters for this context. 
		if (!empty($simpleJobs) && is_object($simpleJobs))
		{
			$this->checkLabelFields();
			
			foreach ($simpleJobs as $key => $value)
			{
				$paramsJS = array();

				if (strpos($key, '_') === false && $value)
				{
					$paramsJS['target'] = $value;
					$paramsJS['chopText'] = (boolean) $simpleJobs->{$key . '_chopText'};
					$paramsJS['maxChars'] = (integer) $simpleJobs->{$key . '_maxChars'};
					$paramsJS = array_merge($paramsJS, $this->labelFields);
					HTMLHelper::_('charactercounterghsvs.charactercounter', $paramsJS);
				}
			}
		}
		
		


return;

##########Experts
		$CountersOrig = $this->params->get('wheres');

		if (empty($CountersOrig) || !is_object($CountersOrig))
		{
			return;
		}

		
		$jinput = $this->app->input;
		
		$layout = $jinput->get('layout', '');
		
		$CountersCollected = new stdClass;

		foreach ($CountersOrig as $key => $Counter)
		{
			if (!$Counter->active)
			{
				continue;
			}
			
			if (!trim($Counter->target))
			{
				continue;
			}
#echo ' 4654sd48sa7d98sD81s8d71dsa ' . print_r($Counter->context, true);exit;
			if (strpos($Counter->context, $context, 0) === false)
			{
				continue;
			}
			elseif ($Counter->context)
			{
				$parts = explode('|', $Counter->context);
				@list($Context, $Layout, $test) = $parts;
				
				$Layout = $Layout ?? '';
				
				if ($Context !== $context)
				{
					continue;
				}

				if ($Layout && $Layout !== $layout)
				{
					continue;
				}
				
				$CountersCollected->$key = $Counter;
			}
		}
		
		unset($CountersOrig, $Counter);
		
		if (empty($CountersCollected))
		{
			return;
		}

		$checks = array('charsTypedLabel', 'charsRemainLabel', 'charsMaxLabel');

		foreach ($checks as $key => $check)
		{
			$temp = $this->params->get($check);
			
			if (!trim($temp))
			{
				unset($checks[$key]);
				continue;
			}
			unset($checks[$key]);
			$checks[$check] = $temp;
		}

		foreach ($CountersCollected as $Counter)
		{
			$paramsJS = array(
				'target' => $Counter->target,
				'chopText' => (boolean) $Counter->chopText,
				'maxChars' => (int) $Counter->maxChars,
			);
			
			$paramsJS = array_merge($paramsJS, $checks);
			
			HTMLHelper::_('charactercounterghsvs.charactercounter', $paramsJS);
			#echo ' 4654sd48sa7d98sD81s8d71dsa ' . print_r($paramsJS, true);exit;
		}

return;
		
		$paramsJS = array(
			// Mandatory and UNIQUE CSS selector of page.
			// Only the first found element will get a counter!
			'target' => '#jform_metadesc',
			// works, too:
			// 'selector' => '.this .that #jform_metadesc',

			// Optional parameters:

			'chopText' => true, // Set maxchars attribute of field.
			'maxChars' => 60,
			
			// Strings: Use language strings if you want.
			/*'charsTypedLabel'
				=> 'Plürs / " ! ß :' . "\n\t",*/
			//'charsRemainLabel' 
			//	=> 'SOME_LANGUAGE_STRING',
			'charsMaxLabel' 
				=> '/',
		);
		HTMLHelper::_('charactercounterghsvs.charactercounter', $paramsJS);

		$paramsJS = array(
			// Mandatory:
			'target' => '.admin.com_content.view-article #jform_metakey',
			
			// Optional:
			'maxChars' => $this->params->get('maxChars', 40),
			'charsTypedLabel'
				=> '',
			'charsRemainLabel' 
				=> '|',
			'charsMaxLabel' 
				=> '|',
			'fileNameSuffix' => '-uncompressed',
		);
		HTMLHelper::_('charactercounterghsvs.charactercounter', $paramsJS);		
	}
	
	protected function checkLabelFields()
	{
		if (is_null($this->labelFieldsChecked))
		{
			// Something entered by user in these fields?
			// Otherwise fall back to default values later on in HTMLHelper.
			foreach ($this->labelFields as $key => $check)
			{
				$temp = $this->params->get($check);
				
				if (!trim($temp))
				{
					unset($this->labelFields[$key]);
					continue;
				}
				unset($this->labelFields[$key]);
				$this->labelFields[$check] = $temp;
			}
			$this->labelsChecked = true;
		}
		#return $this->labelFields;
	}
}
