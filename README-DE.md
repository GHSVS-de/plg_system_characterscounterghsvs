# plg_system_characterscounterghsvs
- Joomla-System-Plugin. J!3 und J!4.
- Danke, Danke, Danke: Bearbeitetes JavaScript basierend auf [VCountdown 0.0.3 | (c) 2016 Pedro Rogério | MIT License](https://github.com/pinceladasdaweb/VCountdown)

## Neue Funktionen seit Version 2021.08.10
- **Neu:** Kann bei der Migration von Joomla 3 nach 4 helfen, um Meta-Daten wie Meta-Beschreibungen oder Meta-Schlüsselworte zu schützen, die nach der Migration beim Speichern von Einträgen unerwartet verloren gehen könnten. Siehe Überschrift [Warum die Wiederbelebung dieses Plugins mit Joomla 4](#why-the-revival-of-this-plugin-with-joomla-4) unten.

## Andere Features
- Optional: Fügt Zeichenzähler zu einigen Text- und Textarea-Feldern im Backend hinzu. Vollständig konfigurierbar.
- Optional: Hinzufügen des Attributs `required` zu einigen Feldern, um das Speichern zu blockieren, wenn das Feld leer ist.
- Bringt einen `JHtml-Helper` mit (nicht dokumentiert).

## Einschränkungen
- **Arbeitet nur im Backend. Funktioniert nicht mit Frontend-Bearbeitung, da keine Zeit zum Testen.
- Nicht a11y.
- Ich bin mein eigener und einziger Tester. Ich habe versucht, mein Bestes zu geben.
- Ich habe nur mittelmäßige, langsam wachsende JavaScript Programmierkenntnisse, wenn wir über JQuery-losen Code sprechen. Trotzdem hat das JavsScript nur eine Größe von ca. 3kB.

### Probleme, Bugs, Fragen, Vorschläge: EN oder DE
- https://github.com/GHSVS-de/plg_system_characterscounterghsvs/issues
- https://ghsvs.de/kontakt

## Warum die Wiederbelebung dieses Plugins mit Joomla 4
### Hauptsächlich: Verhinderung von Datenverlusten einiger Felder nach Joomla 3-4 Migration

- In Eile? Siehe Überschrift [Kurzanleitung für Joomla 3-4-Migrationen für grundlegende Zwecke](#quick-guide-for-joomla-3-4-migrations-and-basic-purposes)
- Nach der Migration befinden sich alle in Joomla 3 eingegebenen Daten noch in der Datenbank von Joomla 4.
- - Allerdings kann es bei einigen Feldern zu Datenverlusten kommen, wenn Joomla-Einträge gespeichert werden, ohne dass die betroffenen Daten vorher angepasst wurden.
- - Allerdings werden einige Daten nicht mehr in voller Länge im Joomla-4-Backend angezeigt. Wie kann man sie dann anpassen, ohne in der Datenbank suchen zu müssen?
- - Allerdings werden einige Daten gar nicht mehr angezeigt. Wie kann man sie sehen und entscheiden, ob sie noch benötigt werden, ohne in der Datenbank zu suchen, bevor man den betreffenden Joomla-Eintrag speichert?

#### Die Idee dahinter ist

- Installieren und konfigurieren Sie das Plugin in Joomla 3.
- Führen Sie die Joomla 3-4 Migration durch.
- Alle Daten sind danach noch im Backend sichtbar und können auf Wunsch bearbeitet werden. So haben Sie zumindest die Möglichkeit, diese Daten im Backend einzusehen und bei Bedarf per Copy-Paste zu speichern. Oder was auch immer Ihrem Arbeitsablauf entspricht. Freiheit der Wahl...
- Schützen Sie z.B. `Meta-Beschreibungen` in Joomla 4 davor, dass sie destruktiv abgeschnitten werden, wenn sie in Joomla 3 länger als 160 Zeichen angelegt wurden.
- Zum Beispiel, Anzeige von `Meta-Schlüsselwörtern` in `Menü-Einträgen`. Dieses Feld wurde in Joomla 4 ersatzlos entfernt, kommt aber mit diesem Plugin zurück, wenn es entsprechend konfiguriert ist.
- Beim Speichern eines Joomla-Eintrags bleiben alle alten Daten erhalten, auch wenn Sie noch keine Zeit haben, sich um die betreffenden Meta-Felder zu kümmern.
- Wenn die Arbeit getan ist, wann auch immer, deinstallieren Sie das Plugin und leben Sie mit den Einstellungen und Einschränkungen von Joomla...
- ...oder lassen Sie das Plugin weiterlaufen und arbeiten Sie wie gewohnt mit den im Plugin konfigurierten Einstellungen weiter.
- Es liegt an Ihnen, wie viele Zeichen Sie pro Feld erlauben oder nur empfehlen, ob Sie einen Zeichenzähler haben wollen, der nur warnt oder weitere Eingaben blockiert und so weiter.
- Deaktivieren Sie harte Feldlängeneinstellungen (`maxlength`). Passen Sie sie an, indem Sie den Zähler für die betroffenen Felder aktivieren.
- Deaktivieren Sie den nicht konfigurierbaren und restriktiven Joomla-4-Core-Zeichenzähler.
- Vermeiden Sie lästige `JLayout`-Overrides. Ja, auch das ist möglich, aber nicht wirklich flexibel zu handhaben.
- Vermeiden Sie die Programmierung eines eigenen Plugins, das ähnliche Dinge wie dieses tut. Ja, das ist auch möglich, aber wer kann das schon oder hat die Zeit und Lust dazu?

## Welche Felder können konfiguriert werden
- Auf Bearbeitungsseiten für `Artikel`, `Kategorie`, `Menü-Eintrag`, `Kontakt` vom Standard-Joomla:
- - Feld <code>Meta-Beschreibung</code>
- - Feld <code>Meta-Schlüsselworte</code>
- - Feld <code>Titel</code> oder <code>Name</code> (letzteres bei Kontakt).
- - Feld <code>Alias</code>
- Theorie: Spielkinder können [myForm.json](https://github.com/GHSVS-de/plg_system_characterscounterghsvs/blob/master/src/src/Form/myForm.json) anpassen und testen, wenn sie denken, dass andere Ansichten oder Text/Textarea-Felder es wert sind, auch ähnliche Konfigurations-Möglichkeiten zu erhalten. Beachten Sie, dass die Datei bei Plugin-Updates überschrieben wird. Machen Sie Vorschläge, wenn Sie denken, dass eine (kostenlose(!!!)) Komponente es wert ist, in das Plugin integriert zu werden.

### Mögliche Einstellungen für jedes Feld einzeln
- <code>Aktivierung (z.B. Einstellfeld "Meta Beschreibung")</code>: JA/NEIN. Wenn NEIN: Es wird nichts passieren. Der Joomla-Core hat die Kontrolle.
- Wenn JA: Es werden die globalen Einstellungen verwendet:
- - `[removeCharcounter]`. Joomla's Zeichenzähler entfernen: JA/NEIN. Empfohlen: JA. Zumindest für die Joomla-3-4-Migration.
- - `[removeMaxlength]`. Entferne `maxlength`-Attribut/Beschränkung: JA/NEIN. Empfohlen: JA. Zumindest für die Joomla 3-4 Migration.
- `Feld(er) erzwingen`: JA/NEIN. Nicht immer verfügbar. Wenn JA: Erzwingt das Laden von fehlenden Feldern in Joomla 4. Z.B. `Meta-Schlüsselworte` für Menü-Einträge.
- `Zähler aktivieren`: JA/NEIN. Wenn JA: Der Zeichen-Zähler

Übersetzt mit www.DeepL.com/Translator (kostenlose Version)



# Be patient! Work in progress!
- If you want to test, install latest version! But not in productive environments.

# plg_system_characterscounterghsvs
- Joomla system plugin. J!3 and J!4.
- **New:** Helps during Joomla 3-4 migration to protect data. See headline [Why the revival of this plugin with Joomla 4](#why-the-revival-of-this-plugin-with-joomla-4) below.
- Optional: Adds characters counter to some text and textarea fields in back-end. Fully configurable.
- Optional: Add required attribute to some fields to block saving if field empty.
- Establishes a JHtml helper, too (not documented).
- Edited JavaScript based upon [VCountdown 0.0.3 | (c) 2016 Pedro Rogério | MIT License](https://github.com/pinceladasdaweb/VCountdown)

## Restrictions
- **Works only in back-end. Works not with frontend-editing because no time to test it.**
- Not a11y.
- I am my own and single tester. I tried to do my best.
- I have only moderate, slowly growing, JavaScript programming skills, if we talk about JQuery-less codes.

### Issues, Bugs, Questions, Suggestions: DE or EN
- https://github.com/GHSVS-de/plg_system_characterscounterghsvs/issues
- https://ghsvs.de/kontakt

## Why the revival of this plugin with Joomla 4
### Mainly: Preventing data loss of some fields after Joomla 3-4 migration

- You are in a hurry? See headline [Quick guide for Joomla 3-4 migrations and basic purposes](#quick-guide-for-joomla-3-4-migrations-and-basic-purposes)
- After migration, all data entered in Joomla 3 is still in the database of Joomla 4.
- However, data loss can occur for some fields when saving entries/items without adapting concerned data before.
- However, some data are not visible in full length in Joomla 4 backend. How to adapt them without searching in database?
- However, some data can't be adapted or copied because not visible anymore in Joomla's backend. How to see them and decide if still needed without searching in database before you save the concerned entry?

#### The idea behind it is

- Install and configure the plugin in Joomla 3.
- Perform the Joomla 3-4 migration.
- All data is still visible in the backend afterwards and can be edited if desired. This way you at least have the possibility to view this data in the backend and save it by copy-paste if necessary. Or whatever matches your workflow. Freedom of choice...
- For example, protect `meta descriptions` in Joomla 4 from being destructively truncated if they were created longer than 160 characters in Joomla 3.
- For example, display `meta keywords` in `menu items`. This field has been removed in Joomla 4 without replacement but comes back with this plugin if configured accordingly.
- When saving an entry, all old data is preserved, even if you don't have time to take care of concerned meta fields yet.
- If the work is done, whenever, uninstall the plugin and live with Joomla's settings and restrictions...
- ...or let the plugin continue to run and continue working as usual with the settings configured in the plugin.
- It's up to you how many characters you allow per field or only recommend, whether you want to have a character counter, which just warns or blocks further typing and so on.
- Deactivate rude field length settings (`maxlength`). Adapt them by activating the counter for concerned fields.
- Deactivate the non-configurable and restrictive Joomla 4 core character counter.
- Avoid annoying `JLayout` overrides. Yes, this is also possible, but not really flexible to handle.
- Avoid programming of a custom plugin that does similiar things like this one. Yes, this is also possible, but who is able to do that or has the time?

## Which fields can be configured
- On edit pages for `Article`, `Category`, `Menu Item`, `Contact` of standard Joomla:
- - Field <code>Meta Description</code>
- - Field <code>Meta Keywords</code>
- - Field <code>Title</code> or <code>Name</code> (the latter in contact).
- - Field <code>Alias</code>
- Theory: Play children can adapt and test [myForm.json](https://github.com/GHSVS-de/plg_system_characterscounterghsvs/blob/master/src/src/Form/myForm.json) if they think other views or text/textarea fields are worth to get also similiar configuration features. Note that the file will be overwritten with plugin updates. Make suggestions if you think a (free(!!!)) component is worth integrating into the plugin.

### Possible settings for each field individually
- <code>Activation (named e.g. "Meta Description")</code>: JA/NEIN. If NO: Nothing will happen. Joomla core rules.
- - If JA: Global settings will be used:
- - - `[removeCharcounter]`. Remove Joomla's character counter: JA/NEIN. Recommended: JA. At least for Joomla 3-4 migration.
- - - `[removeMaxlength]`. Remove `maxlength` attribute/limitation: JA/NEIN. Recommended: JA. At least for Joomla 3-4 migration.
- - `Force field(s)`: JA/NEIN. Not always available. If JA: Forces loading of missing fields in Joomla 4. E.g. `meta keywords` for menu items.
- - `Enable Counter`: JA/NEIN. If JA: The counter of this plugin will be used.
- - - <code>maxChars</code>: Your recommended characters limit.
- - - <code>chopText</code>: If JA, limit text length to <code>maxChars</code> characters and block further typing. Non-destructive if text loaded from database was already longer than this value before. You'll see and save it in full length. Sets a <code>maxlength</code> attribute or adjusts an existing one.
- - <code>Required</code>: JA/`Joomla settings decide`. If JA: Saving of item is prevented if the field is empty. The vaguely named setting `Joomla settings decide` means: The plugin does nothing (as long as I haven't tested what may happen when I remove a `required` attribute where Joomla has set it consciously or just stupidly).
- - - Not available for fields `Title/Name` and `Alias`. They are always mandatory.

## Quick guide for Joomla 3-4 migrations and basic purposes
- Install and configure the plugin in Joomla 3 before migration.
- - **OR** install and configure the plugin in Joomla 4 after migration but before you save any entries/items.
- In tabulator Global settings:
- - Activate `[removeCharcounter]`.
- - Activate `[removeMaxlength]`.
- In each tabulator (Article, Contact ...) set all main fields (Meta Description, Meta Keywords ...) to JA (activate).
- Activate sub field `Force field(s)` where available (just Menu Items > Meta Keywords at the moment).
- `Required` and `Enable Counter` not necessary.

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
