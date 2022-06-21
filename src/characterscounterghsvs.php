<?php
defined('_JEXEC') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Registry\Registry;

class PlgSystemCharacterscounterghsvs extends CMSPlugin
{
	protected $app;

	protected $db;

	// 2019-01-10: $autoloadLanguage is buggy in current J4 alpha7.
	// https://github.com/joomla/joomla-cms/issues/17444
	// Force lang load elsewhere!!
	protected $autoloadLanguage = true;

	protected static $basepath = 'plg_system_characterscounterghsvs';

	function __construct(&$subject, $config = [])
	{
		parent::__construct($subject, $config);

		HTMLHelper::addIncludePath(__DIR__ . '/src/Html');
	}

	public function onContentPrepareForm(Form $form, $data)
	{
		if (!$this->app->isClient('administrator'))
		{
			return;
		}

		$jinput = $this->app->input;
		$layout = $jinput->get('layout', '');
		$option = $jinput->get('option', '');
		$view = $jinput->get('view', '');
		$extension_id = (int) $jinput->get('extension_id', 0);
		$isMe = ($option === 'com_plugins' && $layout === 'edit'
			&& $view === 'plugin' && $extension_id);

		// A bit paranoid, isn't it?
		if ($isMe && (int) $this->params->get('isMe') !== $extension_id)
		{
			$query = $this->db->getQuery(true)
				->select($this->db->qn('extension_id'))
				->from($this->db->qn('#__extensions'));

			if (version_compare(JVERSION, '4', 'lt'))
			{
				$query->where($this->db->qn('extension_id') . ' = ' . $extension_id)
				->where($this->db->qn('element') . ' = ' . $this->db->q($this->_name))
				->where($this->db->qn('folder') . ' = ' . $this->db->q($this->_type))
				->where($this->db->qn('type') . ' = ' . $this->db->q($view));
			}
			else
			{
				$query->where($this->db->qn('extension_id') . ' = :extension_id')
				->where($this->db->qn('element') . ' = :element')
				->where($this->db->qn('folder') . ' = :folder')
				->where($this->db->qn('type') . ' = :type')
				->bind(
					':extension_id',
					$extension_id,
					Joomla\Database\ParameterType::INTEGER
				)
				->bind(':element', $this->_name, \Joomla\Database\ParameterType::STRING)
				->bind(':folder', $this->_type, \Joomla\Database\ParameterType::STRING)
				->bind(':type', $view, \Joomla\Database\ParameterType::STRING);
			}

			$this->db->setQuery($query);

			if (!$this->db->loadResult())
			{
				$isMe = false;
			}
		}

		$formData = json_decode(file_get_contents(__DIR__
			. '/src/Form/myForm.json'));
		$langPrefix = 'PLG_SYSTEM_CHARACTERSCOUNTERGHSVS_';

		// We are in the plugin. Build configuration form.
		if ($isMe === true)
		{
			if (is_object($data))
			{
				$data->params['allowDeactivation'] = '0';
			}

			$addform = new SimpleXMLElement('<form />');
			$mainFields = $addform->addChild('fields');
			$mainFields->addAttribute('name', 'params');

			// Intermezzo for easier isMe detection. $extension_id to a hidden field.
			$basic = $mainFields->addChild('fieldset');
			$basic->addAttribute('name', 'basic');
			$isMeField = $basic->addChild('field');
			$isMeField->addAttribute('type', 'hidden');
			$isMeField->addAttribute('name', 'isMe');
			$isMeField->addAttribute('default', $extension_id);

			// Tabulators like 'Article', 'Category'.
			// $tab is soemthing like "com_menus:item|edit" and name of the <fields>.
			foreach ($formData as $tab => $tabData)
			{
				$spacerCount = 0;
				$name = 'formData_' . $tabData->title;
				$label = $langPrefix . strtoupper($name);

				$headlineLabel = Text::_('PLG_SYSTEM_CHARACTERSCOUNTERGHSVS_'
					. strtoupper($tabData->option . '_' . $tabData->view . '_'
					. $tabData->layout));
				$headlineLabel .= ' <code>' . $tab . '</code>';

				$tabFieldset = $mainFields->addChild('fieldset');
				$tabFieldset->addAttribute('name', $name);
				$tabFieldset->addAttribute('label', $label);

				// Tabulator-Description?
				if (!empty($tabData->description))
				{
					$tabFieldset->addAttribute(
						'description',
						Text::_($tabData->description)
					);
				}

				$subFields = $tabFieldset->addChild('fields');
				$subFields->addAttribute('name', $tab);

				$headline = $subFields->addChild('field');
				$headline->addAttribute('type', 'spacer');
				$headline->addAttribute('name', $tabData->title . 'spacer' . ++$spacerCount);
				$headline->addAttribute('label', $headlineLabel);

				// Fields inside tabulator that get a counter. E.g. 'metadesc'.
				foreach ($tabData->fields as $fieldName => $field)
				{
					$label = $langPrefix . strtoupper($fieldName);

					/* Actvation field for e.g. 'metadesc' field. It contains the CSS
						selector in JYES <option>. */
					$addField = $subFields->addChild('field');
					$addField->addAttribute('name', $fieldName);
					$addField->addAttribute('type', 'list');
					$addField->addAttribute('default', '0');
					$addField->addAttribute('filter', 'string');
					$addField->addAttribute('label', $label);
					// Lazy, lazy:
					$addField->addAttribute('description', '[' . $field->selector . ']');
					$option = $addField->addChild('option', 'JNO');
					$option->addAttribute('value', '0');
					$option = $addField->addChild('option', 'JYES');
					$option->addAttribute('value', $field->selector);
					$showon = $fieldName . ':' . $field->selector;

					/* Enabler for 'loadXmlFields'. E.g. metakeys are missing in menu item
						since Joomla 4 */
					if (!empty($field->loadXmlFields))
					{
						$loadXmlFields = '<code>' . implode(', ', $field->loadXmlFields)
							. '</code>';
						$name = $fieldName . '_forceFields';
						$label = $langPrefix . 'FORCE_FIELDS';
						$description = Text::sprintf($label . '_DESC', $loadXmlFields);
						$addField = $subFields->addChild('field');
						$addField->addAttribute('name', $name);
						$addField->addAttribute('type', 'list');
						$addField->addAttribute('default', '1');
						$addField->addAttribute('filter', 'integer');
						$addField->addAttribute('label', $label);
						$addField->addAttribute('description', $description);
						$option = $addField->addChild('option', 'JNO');
						$option->addAttribute('value', 0);
						$option = $addField->addChild('option', 'JYES');
						$option->addAttribute('value', 1);
						$addField->addAttribute('showon', $showon);
					}

					// Enabler for character counter.
					$name = $fieldName . '_counter';
					$label = $langPrefix . 'ENABLE_COUNTER';
					$addField = $subFields->addChild('field');
					$addField->addAttribute('name', $name);
					$addField->addAttribute('type', 'list');
					$addField->addAttribute('default', '0');
					$addField->addAttribute('filter', 'integer');
					$addField->addAttribute('label', $label);
					$option = $addField->addChild('option', 'JNO');
					$option->addAttribute('value', 0);
					$option = $addField->addChild('option', 'JYES');
					$option->addAttribute('value', 1);
					$addField->addAttribute('showon', $showon);

					// Used by the following child fields.
					$showonCounter = $showon . '[AND]' . $name . ':1';

					// Now build the child fields. E.g. 'maxChars'.
					foreach ($field->settings as $setting => $default)
					{
						$name = $fieldName . '_' . $setting;
						$label = $langPrefix . strtoupper($setting);
						$description = $label . '_DESC';

						// Base.
						$addField = $subFields->addChild('field');
						$addField->addAttribute('name', $name);
						$addField->addAttribute('label', $label);
						$addField->addAttribute('description', $description);
						$addField->addAttribute('default', $default);

						// Now variants. E.g. other type or filter.
						switch ($setting)
						{
							case 'maxChars':
								$addField->addAttribute('type', 'number');
								$addField->addAttribute('min', 1);
								$addField->addAttribute('filter', 'integer');
								$addField->addAttribute('showon', $showonCounter);
							break;
							case 'chopText':
							case 'required':
								$addField->addAttribute('type', 'list');

								if ($setting === 'chopText')
								{
									$addField->addAttribute('filter', 'integer');
									$option = $addField->addChild('option', 'JNO');
									$option->addAttribute('value', 0);
									$option = $addField->addChild('option', 'JYES');
									$option->addAttribute('value', 1);
									$addField->addAttribute('showon', $showonCounter);
								}
								else
								{ // required
									// Must be adjusted for e.g. "menu-meta_description:params".
									$requiredOptionValue = $fieldName;

									if (isset($field->formFieldAttribs))
									{
										// Trust that it's an object and filled. Lazyness again.
										$requiredOptionValue = $field->formFieldAttribs->name . ':'
											. $field->formFieldAttribs->group;
									}

									$addField->addAttribute('filter', 'string');
									$option = $addField->addChild('option', $langPrefix
										. 'JOOMLA_RULES');
									$option->addAttribute('value', 0);
									$option = $addField->addChild('option', 'JYES');
									$option->addAttribute('value', $requiredOptionValue);
									$addField->addAttribute('showon', $showon);
								}
							break;
							default:
								# code...
								break;
						}
					}
				}
			}

			$form->load($addform, $reset=false, $path=false);

			if (
				$this->params->get('doNothing', 0)
				&& $this->params->get('doNothingInfo', 0)

				// This orders the message after the danger warning.
				&& !in_array($jinput->get('task', ''), ['apply', 'save'])
			) {
				$this->app->enqueueMessage(
					Text::_('PLG_SYSTEM_CHARACTERSCOUNTERGHSVS_SLEEP_MODE_ACTIVE'),
					'info'
				);
			}

			return;
		}

		if ($this->params->get('doNothing', 0))
		{
			return;
		}

		$context = $form->getName();

		// e.g. com_categories.categorycom_content.
		if (strpos($context, 'com_categories.categorycom_') === 0)
		{
			$context = 'com_categories.category';
		}

		// E.g. <fields name="com_content:article|edit"...
		$fieldKey = str_replace('.', ':', $context) . '|' . $layout;

		// Quickie
		if (!property_exists($formData, $fieldKey)
			|| !count(get_object_vars($formData->$fieldKey)))
		{
			return;
		}

		$myParams = $this->params->get($fieldKey);

		if (!is_object($myParams) || !count(get_object_vars($myParams)))
		{
			return;
		}

		$thisFormData = null;

		// ##############
		// ##### Below is all very unhandy somehow!
		// Meanwhile less unhandy. I try my best.
		// ##############

		/* Clean out. Keep only activated fields.
			$fieldName: e.g. 'metakey' */
		foreach ($formData->$fieldKey->fields as $fieldName => $field)
		{
			$activated = !empty($myParams->$fieldName);

			if ($activated === true && !empty($field->exclude))
			{
				if ($thisFormData === null)
				{
					$thisFormData = new Registry($data);
				}

				/* $excludeKey: E.g. 'type' in menu items $data.
					$excludeValues: E.g. ['heading', 'separator'] */
				foreach ($field->exclude as $excludeKey => $excludeValues)
				{
					$excludeValues = array_flip($excludeValues);

					// Do we have match in $thisFormData?
					if (isset($excludeValues[$thisFormData->get(
						$excludeKey,
						'completelyParanoid'
					)])
					) {
						$activated = false;
						break;
					}
				}
			}

			// Not activated at all.
			if ($activated === false)
			{
				foreach ($myParams as $key => $dummy)
				{
					if (strpos($key, $fieldName . '_') === 0)
					{
						unset($myParams->$key);
					}
				}

				unset($myParams->$fieldName);
			}
			else
			{
				if (!empty($field->loadXmlFields))
				{
					$myParams->{$fieldName . '_loadXmlFields'} =
						$field->loadXmlFields;
				}

				if (!empty($field->formFieldAttribs))
				{
					$myParams->{$fieldName . '_formFieldAttribs'} =
						$field->formFieldAttribs;
				}
			}
		}

		// Check for todos.
		if (count(get_object_vars($myParams)))
		{
			// E.g. 'metadesc', "metadesc_*', 'title', 'title_*'
			foreach ($myParams as $key => $value)
			{
				// The main Yes/No switch like 'metadesc'. The value is CSS selector.
				if (strpos($key, '_') === false)
				{
					// The field is activated AND counter enabled.
					if ($myParams->{$key . '_counter'})
					{
						$paramsJS = [
							'target' => $value,
							'chopText' => (boolean) $myParams->{$key . '_chopText'},
							'maxChars' => (integer) $myParams->{$key . '_maxChars'},
							'removeMaxlength' => (boolean) $this->params->get(
								'removeMaxlength',
								0
							),
						];

						// Configure and load counter JS.
						HTMLHelper::_('charactercounterghsvs.charactercounter', $paramsJS);
					}

					$group = null;
					$field = $key;

					if (!empty($myParams->{$key . '_formFieldAttribs'}))
					{
						$group = $myParams->{$key . '_formFieldAttribs'}->group;

						// E.g. 'menu-meta_description' is the correct form field name.
						$field = $myParams->{$key . '_formFieldAttribs'}->name;
					}

					// Must be early.
					if (!empty($myParams->{$key . '_loadXmlFields'})
						&& $myParams->{$key . '_forceFields'}
					) {
						//Form::addFormPath(__DIR__ . '/src/Form');
						$formsPath = __DIR__ . '/src/Form/';

						foreach ($myParams->{$key . '_loadXmlFields'} as $fieldFile)
						{
							$form->loadFile($formsPath . $fieldFile . '.xml', $reset = true);
						}
					}

					// Remove Joomla's character counter. @since Joomla 4.
					if ($this->params->get('removeCharcounter', 1))
					{
						$form->setFieldAttribute($field, 'charcounter', null, $group);
					}

					// Remove maxlength. THIS IS REDUNDANT! See JS.
					if ($this->params->get('removeMaxlength', 1))
					{
						$form->setFieldAttribute($field, 'maxlength', null, $group);
					}

					if ($required = ($myParams->{$key . '_required'} ?? 0))
					{
						$form->setFieldAttribute($field, 'required', 'true', $group);
					}
				}
			}
		}
	}

	public function onExtensionBeforeSave($context, $table, $isNew)
	{
		// Should be enough
		if (($isMe = !empty($table->params)
			&& $table->element === $this->_name
			&& $table->folder === $this->_type)
			&& strpos($table->params, '"characterscounterghsvsplugin":') !== false
			&& strpos($table->params, '"isMe":') !== false
		) {
			if (
				$table->enabled == 0
				&& strpos($table->params, '"allowDeactivation":"0"') !== false
			) {
				$this->app->enqueueMessage(
					Text::_('PLG_SYSTEM_CHARACTERSCOUNTERGHSVS_ALLOWDEACTIVATION_ERROR'),
					'error'
				);
				$table->enabled = 1;
			}
		}
	}
}
