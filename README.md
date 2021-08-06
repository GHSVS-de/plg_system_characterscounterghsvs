# Be patient! Work in progress!
- If you want to test, install latest version!

# plg_system_characterscounterghsvs
- Joomla system plugin. Adds characters counter to some text and textarea fields in back-end. Configurable. Establishes a JHtml helper, too (not documented).
- Edited JavaScript based upon [VCountdown 0.0.3 | (c) 2016 Pedro Rogério | MIT License](https://github.com/pinceladasdaweb/VCountdown)

## Restrictions
- Works only in back-end. Works not with frontend-editing.
- Not a11y.

## To which form fields can you add the character counter?
- On edit pages for `Article`, `Category`, `Menu Item` of standard Joomla:
- - Field <code>Meta Description</code>
- - Field <code>Meta Keywords</code>
- - Field <code>Title</code>
- - Field <code>Alias</code>

### Possible settings for each field.
- <code>Activation</code>: YES/NO.
- <code>maxChars</code>: Characters limit.
- <code>chopText</code>: If YES, limit text length to <code>maxChars</code> characters and block further typing.
- - Non-destructive if text loaded from database was already longer than this value before.
- - Sets a <code>maxlength</code> attribute or adjusts an existing one.
- <code>Required</code> If YES: Saving is prevented if the field is empty.

### Global settings
- <code>removeCharcounter</code>: Remove Joomla's core character counter (since J!4) from form fields that you activate in the plugin. YES is recommended to avoid conflicts..
- <code>removeMaxlength</code>: Remove <code>maxlength</code> attribute from form fields that you activate in this plugin. YES is recommended to avoid conflicts.


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
