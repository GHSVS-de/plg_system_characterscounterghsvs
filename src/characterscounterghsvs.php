<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\CMSPlugin;

class PlgSystemCharacterscounterghsvs extends CMSPlugin
{
	protected $app;

	// 2019-01-10: $autoloadLanguage is buggy in current J4 alpha7.
	// https://github.com/joomla/joomla-cms/issues/17444
	// Force lang load elsewhere!!
	protected $autoloadLanguage = true;

	protected static $basepath = 'plg_system_characterscounterghsvs';

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
	}
}
