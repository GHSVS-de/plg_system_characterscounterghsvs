# Be patient! Work in progress.

- [Deutsche Beschreibung](https://github.com/GHSVS-de/plg_system_characterscounterghsvs/blob/master/README-DE.md#plg_system_characterscounterghsvs)

<div id="div_toc" class="div_toc"><ul><li style="list-style: none;"><a href="#plg_system_characterscounterghsvs" style="color: rgb(3, 102, 214); font-weight: bold;">plg_system_characterscounterghsvs</a></li><li style="list-style: none;"><a href="#new-features-since-version-20210810" style="color: rgb(3, 102, 214);">&nbsp;&nbsp;&nbsp;New features since version 2021.08.10</a></li><li style="list-style: none;"><a href="#other-features" style="color: rgb(3, 102, 214);">&nbsp;&nbsp;&nbsp;Other features</a></li><li style="list-style: none;"><a href="#restrictions" style="color: rgb(3, 102, 214);">&nbsp;&nbsp;&nbsp;Restrictions</a></li><li style="list-style: none;"><a href="#issues-bugs-questions-suggestions-de-or-en" style="color: rgb(3, 102, 214);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Issues, Bugs, Questions, Suggestions: DE or EN</a></li><li style="list-style: none;"><a href="#why-the-revival-of-this-plugin-with-joomla-4" style="color: rgb(3, 102, 214);">&nbsp;&nbsp;&nbsp;Why the revival of this plugin with Joomla 4</a></li><li style="list-style: none;"><a href="#mainly-preventing-data-loss-of-some-fields-after-joomla-3-4-migration" style="color: rgb(3, 102, 214);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mainly: Preventing data loss of some fields after Joomla 3-4 migration</a></li><li style="list-style: none;"><a href="#which-fields-can-be-configured" style="color: rgb(3, 102, 214);">&nbsp;&nbsp;&nbsp;Which fields can be configured</a></li><li style="list-style: none;"><a href="#possible-settings-for-each-field-individually" style="color: rgb(3, 102, 214);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Possible settings for each field individually</a></li><li style="list-style: none;"><a href="#quick-guide-for-joomla-3-4-migrations-for-basic-purposes" style="color: rgb(3, 102, 214);">&nbsp;&nbsp;&nbsp;Quick guide for Joomla 3-4 migrations for basic purposes</a></li></ul></div>

# plg_system_characterscounterghsvs
- Joomla system plugin. J!3 and J!4.
- Thanks, thanks, thanks: Edited JavaScript based upon [VCountdown 0.0.3 | (c) 2016 Pedro Rogério | MIT License](https://github.com/pinceladasdaweb/VCountdown)

## To have mentioned it early
- **You must activate the plugin to see all tabulators in plugin configuration.** But relax! As long as no fields are activated in the plugin configuration, the plugin does nothing.

## New features since version 2021.08.10
- Can help when migrating from Joomla 3 to 4 to protect meta data such as meta descriptions or meta keywords that are no longer displayed at all or might be unexpectedly lost after migration when saving Joomla entries.
- See headline [Why the revival of this plugin with Joomla 4](#why-the-revival-of-this-plugin-with-joomla-4) below for more details.
- See headline [Quick guide for Joomla 3-4 migrations for basic purposes](#quick-guide-for-joomla-3-4-migrations-for-basic-purposes) below.

## Other features
- Optional: Adds character counters to some text and textarea fields in back-end. Individually configurable.
- Optional: Add `required` attribute to some fields to block saving if field is empty.
- Establishes a `JHtml helper` (not documented).

## Restrictions
- This plugin does not bring back the Joomla 3 functionalities in Joomla 4 to add meta keywords in the frontend of the page! It only saves them from deletion.
- **Works only in back-end. Works not with frontend-editing** because I have no time to test it.
- Not a11y.
- I am my own and single tester. I tried to do my best.

### Issues, Bugs, Questions, Suggestions: DE or EN
- https://github.com/GHSVS-de/plg_system_characterscounterghsvs/issues
- https://ghsvs.de/kontakt

## Why the revival of this plugin with Joomla 4
### Mainly: Preventing data loss of some fields after Joomla 3-4 migration

- You are in a hurry? See headline [Quick guide for Joomla 3-4 migrations for basic purposes](#quick-guide-for-joomla-3-4-migrations-for-basic-purposes).
- After migration, all data entered in Joomla 3 is still in the database of Joomla 4.
- - However, some fields may lose data if Joomla entries are saved without the affected data having been adjusted beforehand.
- - However, some data are not visible in full length in Joomla 4 backend. How to adapt them without searching in database?
- - However, some data is no longer displayed at all. How to see them and decide if still needed without searching in database before you save the concerned Joomla entry?
- Affected are all meta descriptions in Joomla's own components that are longer than 160 characters.
- Affected are the meta keywords of menu items that have been removed entirely in Joomla 4.

#### The idea regarding migration is

- Install, activate(!) and configure the plugin in Joomla 3. [See Quick guide](#quick-guide-for-joomla-3-4-migrations-for-basic-purposes).
- Perform the Joomla 3-4 migration.
- All data entered in Joomla 3 is still visible in the backend afterwards. So you have the possibility to edit, shorten or copy-paste them somewhere ... whatever suits your workflow. Freedom of choice...
- For example, protect `meta descriptions` in Joomla 4 from being destructively truncated if they were created longer than 160 characters in Joomla 3.
- For example, display `meta keywords` in `menu items`. This field has been removed in Joomla 4 without replacement but comes back with this plugin if configured accordingly.
- When saving an entry, all old data is preserved, even if you don't have time to take care of concerned meta fields yet.
- If the work is done, whenever, uninstall the plugin and live with Joomla's settings and restrictions...
- ...or let the plugin continue to run and continue working as usual with the settings configured in the plugin.
- - It's up to you how many characters you allow per field or only recommend, whether you want to have a character counter, which just warns or blocks further typing and so on.
- - Deactivate rude field length settings (`maxlength`). Adapt them by activating the counter for concerned fields.
- - Deactivate the non-configurable and restrictive Joomla 4 core character counter.
- - Avoid annoying `JLayout` overrides. Yes, this is also possible, but not really flexible to handle.
- - Avoid programming of a custom plugin that does similiar things like this one. Yes, this is also possible, but who is able to do that or has the time and desire?

## Which fields can be configured
- On edit pages for `Global Configuration`, `Article`, `Category`, `Menu Item`, `Contact`, `Content language`, `Newsfeed`, `Tag` of standard Joomla:
- - Field <code>Meta Description</code>
- - Field <code>Meta Keywords</code>
- <code>Title/Name</code>, <code>Alias</code> only on pages where it makes sense:
- - Field <code>Title</code> or <code>Name</code> (the latter in contact and newsfeed).
- - Field <code>Alias</code>

### Possible settings for each field individually
- <code>Activation (e.g. setting "Meta Description")</code>.
- - If NO: The plugin does nothing. The Joomla core has control.
- - If YES: Global settings of this plugin will be used:
- - - `[removeCharcounter]`. Remove Joomla's character counter. Recommended: YES. At least for the Joomla 3-4 migration.
- - - `[removeMaxlength]`. Remove `maxlength` attribute/limitation. Recommended: YES. At least for the Joomla 3-4 migration.
- `Force field(s)`. Not always available. If YES: Forces loading of missing fields in Joomla 4. E.g. `meta keywords` for menu items.
- `Enable Counter`. If YES: The character counter of this plugin will be used.
- - <code>[maxChars]</code>: Your recommended characters limit.
- - <code>[chopText]</code>: If YES, limit text length to <code>[maxChars]</code> characters and block further typing. Non-destructive if text loaded from database was already longer than this value before. You'll see and save it in full length. Sets a <code>maxlength</code> attribute or adjusts an existing one.
- <code>Required</code>. If YES: Saving of item is prevented if the field is empty. The vaguely named setting `Joomla defaults decide` means: The plugin does nothing (as long as I haven't tested what may happen when I remove a `required` attribute where Joomla has set it consciously or just stupidly).
- - Not available for fields `Title/Name` and `Alias`. They are always mandatory.

## Quick guide for Joomla 3-4 migrations for basic purposes
- Install, activate(!) and configure the plugin in Joomla 3 before migration.
- - **OR** install, activate(!) and configure the plugin in Joomla 4 after migration but before you save any entries/items.
- In tabulator Global settings:
- - Set `[removeCharcounter]` to YES to disable Joomla's restrictive character counter in all enabled fields.
- - Set `[removeMaxlength]` to YES to disable Joomla's restrictive field lengths in all enabled fields.
- In each tabulator (Article, Contact ...) set all main fields (Meta Description, Meta Keywords ...) to YES (= activation).
- Enable `Force Field(s)` subfields where one is available to display meta keyword fields that have been removed in Joomla 4.
- `Required` and `Enable Counter` settings not necessary.

-----------------------------------------------------

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
