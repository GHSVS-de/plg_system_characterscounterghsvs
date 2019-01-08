<?php
defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
#use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

abstract class JHtmlCharactercounterghsvs
{
	
	protected static $loaded = array();
	protected static $basepath = 'plg_system_characterscounterghsvs';

	public static function charactercounter(
 		$paramsJS = array(),
		// For HTMLHelper::_('script' ...
		$options = array(),
		$debug = null
	){

		if (!is_array($paramsJS) || empty($paramsJS)
			|| empty($paramsJS['target']) || !($paramsJS['target'] = trim($paramsJS['target']))
		){
			return '';
		}

		if ($debug === null)
		{
			$debug = JDEBUG;
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
		
		$lang = Factory::getLanguage();

		$lang->load(static::$basepath, JPATH_PLUGINS . '/system/characterscounterghsvs');
		
		$maxCharsDefault = 150;
		
		$paramsJS['chopText'] = empty($paramsJS['chopText']) ? false : true;
		
		$jsSafe = true;

		$paramsJS['charsTypedLabel'] = $paramsJS['charsTypedLabel'] ?? 
			'PLG_SYSTEM_CHARACTERSCOUNTERGHSVS_TYPED_LABEL';
		Text::script($paramsJS['charsTypedLabel'], $jsSafe);

		$paramsJS['charsRemainLabel'] = $paramsJS['charsRemainLabel'] ?? 
			'PLG_SYSTEM_CHARACTERSCOUNTERGHSVS_REMAIN_LABEL';
		Text::script($paramsJS['charsRemainLabel'], $jsSafe);

		$paramsJS['charsMaxLabel'] = $paramsJS['charsMaxLabel'] ?? 
			'PLG_SYSTEM_CHARACTERSCOUNTERGHSVS_MAX_LABEL';
		Text::script($paramsJS['charsMaxLabel'], $jsSafe);

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

		$fileNameSuffix      = trim($plgParams->get('fileNameSuffix', ''));
		$fileNameSuffixCheck = $fileNameSuffix && $plgParams->get('fileNameSuffixCheck', 1) === 1;

		if (empty(static::$loaded[__METHOD__]['core']))
		{
			$file = static::$basepath . '/vcountdownghsvs' . $fileNameSuffix . '.js';
			
			if ($fileNameSuffixCheck)
			{
				$foundfile = HTMLHelper::_('script',
					$file,
					array(
						//'framework' => false,
	
						//Allow template overrides in html/plg_system_charactercounterghsvs:
						'relative' => $options['relative'] ?? true,
						'pathOnly' => true,
						'detectBrowser' => $options['detectBrowser'] ?? false,
						'detectDebug' => $options['detectDebug'] ?? true,
					)
				);
				
				if (!$foundfile)
				{
					$file = static::$basepath . '/vcountdownghsvs.js';
				}
			}

			HTMLHelper::_('script',
				$file,
				array(
					//'framework' => false,

					//Allow template overrides in html/plg_system_charactercounterghsvs:
					'relative' => $options['relative'] ?? true,
					'pathOnly' => false,
					'detectBrowser' => $options['detectBrowser'] ?? false,
					'detectDebug' => $options['detectDebug'] ?? true,
				)
			);
			
			if ($plgParams->get('loadCSS', 1) === 1)
			{
				$file = static::$basepath . '/vcountdownghsvs' . $fileNameSuffix . '.css';

				if ($fileNameSuffixCheck)
				{
					$foundfile = HTMLHelper::_('stylesheet',
						$file,
						array(
							//Allow template overrides in html/plg_system_charactercounterghsvs:
							'relative' => $options['relative'] ?? true,
							'pathOnly' => true,
							'detectBrowser' => $options['detectBrowser'] ?? false,
							'detectDebug' => $options['detectDebug'] ?? true,
						)
					);

					if (!$foundfile)
					{
						$file = static::$basepath . '/vcountdownghsvs.css';
					}
				}
				
				HTMLHelper::_('stylesheet',
					$file,
					array(
						//Allow template overrides in html/plg_system_charactercounterghsvs:
						'relative' => $options['relative'] ?? true,
						'pathOnly' => false,
						'detectBrowser' => $options['detectBrowser'] ?? false,
						'detectDebug' => $options['detectDebug'] ?? true,
					)
				);
				
			}
			
			static::$loaded[__METHOD__]['core'] = true;
		}

		#$mainWrapperClass = ApplicationHelper::stringURLSafe($paramsJS['target']) . '_counter';

		$paramsJS = json_encode($paramsJS, ($debug && defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : false));

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
