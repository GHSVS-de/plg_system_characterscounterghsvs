# plg_system_characterscounterghsvs
- Joomla system plugin. Adds characters counter to some text and textarea fields in back-end. Configurable. Establishes a JHtml helper, too.
- Edited JavaScript based upon [VCountdown 0.0.3 | (c) 2016 Pedro Rogério | MIT License](https://github.com/pinceladasdaweb/VCountdown)

## Which fields?
On edit pages Article, Category, Menu Item of standard Joomla:
- Field Meta Description
- Field Meta Keywords
- Field Title
- Field Alias
- `Required` setting for each field (message before save if field empty).
- You can activate/deactivate and configure each counter in the plugin configuration.
- Remove core character counter (Joomla 4).
## Restrictions
- Only back-end.
- I use it in Joomla 3/4 and live with the ugly display.
- In Joomla 4.0.0-rc6-dev it conflicts with hard-coded core character counter in fiields with `name="metadesc"`.
- - Needs an override for JLayout textarea.php then. [Ask for details if interested!](https://github.com/GHSVS-de/plg_system_characterscounterghsvs/issues)
## Special for experts
- Uses a custom JHtml/HTMLHelper that you can use somewhere else in your code, too, **if the plugin is enabled**.
### Example:
```
// Build parameters array:
$paramsJS = array(
 'target' => '#jform_metadesc', // Mandatory and UNIQUE CSS selector on the page.

 // Works, too, but <b>only the first found element</b> on the page will get a counter!:
 // 'target' => '.this .that .metadesc',

 // Optional parameters:
 'removeMaxlength' => true, // removes <i>maxlength</i> attributes, e.g. coming from Joomla core.
 'chopText' => true, // <i>chopText</i> adds a <i>maxlength</i> attribute to the field.
 'maxChars' => 60, // Number of charcters before you get a warning or text is chopped.


 // Optional strings overrides. Use custom language strings if you want to.
 'charsTypedLabel' => 'Typed characters:',
 'charsRemainLabel' => 'SOME_LANGUAGE_STRING',
 'charsMaxLabel' => 'ANOTHER_LANGUAGE_STRING',
);

// Finally insert the counter:
HTMLHelper::_('charactercounterghsvs.charactercounter', $paramsJS);

// or old-fashioned:
JHtml::_('charactercounterghsvs.charactercounter', $paramsJS);
```

# My personal build procedure (WSL 1, Debian, Win 10)
- Prepare/adapt `./package.json`.
- `cd /mnt/z/git-kram/plg_system_characterscounterghsvs`

## node/npm updates/installation
- `npm run g-npm-update-check` or (faster) `ncu`
- `npm run g-ncu-override-json` (if needed) or (faster) `ncu -u`
- `npm install` (if needed)

## Build installable ZIP package
- `node build.js`
- New, installable ZIP is in `./dist` afterwards.
- All packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.s

#### For Joomla update server
- Create new release with new tag.
- Get download link for new `dist/plg_blahaba_blubber...zip` **from newly created tag branch** and add to release description.
- Extracts(!) of the update and changelog XML for update and changelog servers are in `./dist` as well. Check for necessary additions! Then copy/paste.
