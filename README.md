# Be patient! Work in progress!
- If you want to test, install latest version!

# plg_system_characterscounterghsvs
- Joomla system plugin. Adds characters counter to some text and textarea fields in back-end. Fully configurable.
- New: Helps during Joomla 3-4 migration to protect data. See headline [Why the revival of this plugin with Joomla 4](#why-the-revival-of-this-plugin-with-joomla-4) below.
- Establishes a JHtml helper, too (not documented).
- Edited JavaScript based upon [VCountdown 0.0.3 | (c) 2016 Pedro Rogério | MIT License](https://github.com/pinceladasdaweb/VCountdown)

## Restrictions
- **Works only in back-end. Works not with frontend-editing.**
- Not a11y.

## Why the revival of this plugin with Joomla 4
### Mainly: Preventing data loss of some fields after Joomla 3-4 migration

- After migration, all data entered in Joomla 3 is still in the database of Joomla 4.
- However, data loss can occur for some fields when saving entries without adapting concerned data before.
- However, some data are not visible in full length in Joomla 4 backend. How to adapt them without searching in database?
- However, some data can't be adapted or copied because not visible anymore in Joomla's backend.

#### The idea behind it is

- Install and configure the plugin in Joomla 3.
- Perform the Joomla 3-4 migration.
- All data is still visible in the backend afterwards and can be edited if desired. This way you at least have the possibility to view this data in the backend and save it by copy-paste if necessary. Or whatever matches your workflow. Freedom of choice...
- For example, protect `meta descriptions` in Joomla 4 from being destructively truncated if they were created longer than 160 characters in Joomla 3.
- For example, display `meta keywords` in `menu items`. This field has been removed in Joomla 4 without replacement but comes back with this plugin if configured accordingly.
- When saving an entry, all old data is preserved, even if you don't have time to take care of concerned meta fields yet.
- Or simply let the plugin continue to run and continue working as usual with the settings configured in the plugin. It's up to you how many characters you allow per field or only recommend, whether you want to have a character counter, which just warns or blocks further typing and so on.
- Enable the deactivation/modification of field lengths (`maxlength`).
- Deactivate the non-configurable and restrictive Joomla 4 core character counter.
- Avoid annoying `JLayout` overrides. Yes, this is also possible, but not really flexible to handle.

## Which fields can be configured
- On edit pages for `Article`, `Category`, `Menu Item`, `Contact` of standard Joomla:
- - Field <code>Meta Description</code>
- - Field <code>Meta Keywords</code>
- - Field <code>Title</code> or <code>Name</code> in contact.
- - Field <code>Alias</code>

### Possible settings for each field individually
- <code>Activation</code>: YES/NO. If NO: Nothing will happen. Joomla core rules.
- - If YES: Global settings will be used:
- - - `[removeCharcounter]`. Remove Joomla's character counter: YES/NO. Recommended: YES. At least for Joomla 3-4 migration.
- - - `[removeMaxlength]`. Remove `maxlength` attribute/limitation: YES/NO. Recommended: YES. At least for Joomla 3-4 migration.
- - `Force field(s)`: YES/NO. Not always available. If YES: Forces loading of missing fields in Joomla 4. E.g. `meta keywords` for menu items.
- - `Enable Counter`: YES/NO. If YES: The counter of this plugin will be used.
- - - <code>maxChars</code>: Your recommended characters limit.
- - - <code>chopText</code>: If YES, limit text length to <code>maxChars</code> characters and block further typing. Non-destructive if text loaded from database was already longer than this value before. You'll see and save it in full length. Sets a <code>maxlength</code> attribute or adjusts an existing one.
- - <code>Required</code>: YES/`Joomla settings decide`. If YES: Saving of item is prevented if the field is empty. The vaguely named setting `Joomla settings decide` means: The plugin does nothing (as long as I haven't tested what may happen when I remove a `required` attribute where Joomla has set it consciously or just stupidly).
- - - Not available for fields `Title/Name` and `Alias`. They are always mandatory.

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
