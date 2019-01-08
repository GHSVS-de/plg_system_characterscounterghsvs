# plg_system_characterscounterghsvs
Joomla plugin that adds charcters counter to some text and textarea fields in back-end.
## Which fields?
On edit pages Article, Category, Menu Item of standard Joomla:
- Field Meta Description
- Field Meta Keywords
- Field Title
- Field Alias
- You can activate/deactivate and configure each counter in the plugin configuration.
## Restrictions
- Only back-end yet
- Tested with nightly build of Joomla! 4.0.0-alpha7-dev
- Target of this plugin is Joomla 4!
- Have a look in the release tab which versions were tested with Joomla 3, too.  
## Special for experts
- Uses a custom HTMLHelper that you can use somewhere else in your code, too, **if the plugin is enabled**.
### Example:
```
// Build parameters array:
$paramsJS = array(
 'target' => '#jform_metadesc', // Mandatory and UNIQUE CSS selector on the page.

 // Works, too, but <b>only the first found element</b> on the page will get a counter!:
 // 'target' => '.this .that .metadesc',

 // Optional parameters:

 'chopText' => true, // <i>chopText</i> adds a <i>maxchars</i> attribute to the field.
 'maxChars' => 60, // Number of charcters before you get a warning or text is chopped.
	
 // Optional strings overrides. Use custom language strings if you want to.
 'charsTypedLabel' => 'Typed characters:',
 'charsRemainLabel' => 'SOME_LANGUAGE_STRING',
 'charsMaxLabel' => 'ANOTHER_LANGUAGE_STRING',
);

// Finally insert the counter:
HTMLHelper::_('charactercounterghsvs.charactercounter', $paramsJS);
```
