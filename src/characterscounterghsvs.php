<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
#use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Form\Form;
#use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Registry\Registry;
#use Joomla\Utilities\ArrayHelper;

class PlgSystemCharacterscounterghsvs extends CMSPlugin
{
	protected $app;

	// 2019-01-10: $autoloadLanguage is buggy in current J4 alpha7.
	// https://github.com/joomla/joomla-cms/issues/17444
	// Force lang load elsewhere!!
	protected $autoloadLanguage = true;

	protected static $basepath = 'plg_system_characterscounterghsvs';

	// User can enter custom labels in plugin.
	protected $labelFields = ['charsTypedLabel', 'charsRemainLabel',
		'charsMaxLabel'];

	protected $labelFieldsChecked = null;

	function __construct(&$subject, $config = array())
	{
		parent::__construct($subject, $config);

		HTMLHelper::addIncludePath(__DIR__ . '/html');
	}

	public function onContentPrepareForm(Form $form, $data)
	{
		if (!$this->app->isClient('administrator'))
		{
			return;
		}

		$jinput = $this->app->input;
		$layout = $jinput->get('layout', '');

		if ($layout !== 'edit')
		{
			return;
		}

		$context = $form->getName();

##########Simple

		// e.g. com_categories.categorycom_content.
		if (strpos($context, 'com_categories.categorycom_') === 0)
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
			// 2019-01-10: $autoloadLanguage is buggy in current J4 alpha7.
			// https://github.com/joomla/joomla-cms/issues/17444
			// Force lang load here!!
			// Decide later if we need it here, too, or only in HTMLHelper or autoloadLanguage is sufficient then.
			$lang = Factory::getLanguage();
			$lang->load(static::$basepath,
				JPATH_PLUGINS . '/system/characterscounterghsvs');

			$this->checkLabelFields();

			foreach ($simpleJobs as $key => $value)
			{
				// The main Yes/No switch like 'metadesc'.
				if (strpos($key, '_') === false)
				{
					if ($value)
					{
						$paramsJS = [
							'target' => $value,
							'chopText' => (boolean) $simpleJobs->{$key . '_chopText'},
							'maxChars' => (integer) $simpleJobs->{$key . '_maxChars'},
							'removeMaxlength' => (boolean) $this->params->get(
								'removeMaxlength', 0),
						];

						// Add language labels if some set.
						$paramsJS = array_merge($paramsJS, $this->labelFields);

						// Configure and load counter JS.
						HTMLHelper::_('charactercounterghsvs.charactercounter', $paramsJS);
					}

					$group = null;
					$field = $key;

					// There are combinations like 'menu-meta_description:params'.
					if (strpos($key, ':') !== false)
					{
						list($field, $group) = explode(':', $key);
					}

					// Remove Joomla's character counter. @since Joomla 4.
					if ($this->params->get('removeCharcounter', 1))
					{
						$form->setFieldAttribute($field, 'charcounter', null, $group);
					}

					// Remove maxlength. THIS IS REDUNDANT! See JS. Remove there!
					if ($this->params->get('removeMaxlength', 1))
					{
						$form->setFieldAttribute($field, 'maxlength', null, $group);
					}

					if ($required = ($simpleJobs->{$field . '_required'} ?? 0))
					{
						$form->setFieldAttribute($field, 'required', 'true', $group);
					}
				}
			}
		}

##########Experts - Not implemented yet
return;

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
		}
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
	}

/*	public function onExtensionBeforeSave($context, $table, $isNew, $data = array())
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
	}*/
}
