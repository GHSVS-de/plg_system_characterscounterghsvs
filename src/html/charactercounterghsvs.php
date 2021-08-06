<?php
defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

abstract class JHtmlCharactercounterghsvs
{

	protected static $loaded = array();
	protected static $basepath = 'plg_system_characterscounterghsvs';

	public static function charactercounter($paramsJS = array())
	{
		if (!is_array($paramsJS) || empty($paramsJS) || empty($paramsJS['target'])
			|| !($paramsJS['target'] = trim($paramsJS['target']))
	){
			return;
		}

		$plgParams = PluginHelper::getPlugin('system', 'characterscounterghsvs');

		if (!$plgParams)
		{
			$plgParams = new Registry;
		}
		elseif ($plgParams && !($plgParams->params instanceof Registry))
		{
			$plgParams = new Registry($plgParams->params);
		}
		else
		{
			$plgParams = $plgParams->params;
		}

		// 2019-01-10: $autoloadLanguage is buggy in current J4 alpha7.
		// https://github.com/joomla/joomla-cms/issues/17444
		// Force lang load here!!
		// Decide later if we need it here, too, or only in plugin.
		$lang = Factory::getLanguage();
		$lang->load(static::$basepath, JPATH_PLUGINS . '/system/characterscounterghsvs');

		$maxCharsDefault = 150;
		$paramsJS['chopText'] = empty($paramsJS['chopText']) ? false : true;
		$paramsJS['charsTypedLabel'] = 'PLG_SYSTEM_CHARACTERSCOUNTERGHSVS_TYPED_LABEL';
		$paramsJS['maxChars'] = $paramsJS['maxChars'] ?? $maxCharsDefault;

		if (! ($paramsJS['maxChars'] = (int) $paramsJS['maxChars']))
		{
			$paramsJS['maxChars'] = $maxCharsDefault;
		}

		ksort($paramsJS);
		$sig = md5(serialize(array($paramsJS)));

		if (!empty(static::$loaded[__METHOD__][$sig]))
		{
			return;
		}

		// Strings available for JS:
		$jsSafe = true;
		Text::script($paramsJS['charsTypedLabel'], $jsSafe);
		$min = JDEBUG ? '' : '.min';

		if (empty(static::$loaded[__METHOD__]['core']))
		{
			$file = static::$basepath . '/vcountdownghsvs' . $min . '.js';

			HTMLHelper::_('script', $file,
				[
					//Allow template overrides in js/plg_system_charactercounterghsvs:
					'relative' => true, 'version' => $min ? 'auto' : time()
				]
			);

			if ($plgParams->get('loadCSS', 1) === 1)
			{
				$file = static::$basepath . '/vcountdownghsvs' . $min . '.css';

				HTMLHelper::_('stylesheet',
					$file,
					[
						//Allow template overrides in css/plg_system_charactercounterghsvs:
						'relative' => true, 'version' => $min ? 'auto' : time()
					]
				);
			}

			static::$loaded[__METHOD__]['core'] = true;
		}

		$paramsJS = json_encode($paramsJS);

		$js = <<<JS
;(function(){
document.addEventListener('DOMContentLoaded',function(){VCountdown($paramsJS);});
})();
JS;
		Factory::getDocument()->addScriptDeclaration($js);

		static::$loaded[__METHOD__][$sig] = true;
		return;
	}
}
