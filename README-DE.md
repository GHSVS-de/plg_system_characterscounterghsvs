# Geduld! In Arbeit.

- [English description](https://github.com/GHSVS-de/plg_system_characterscounterghsvs#readme)

# plg_system_characterscounterghsvs
- Joomla-System-Plugin. J!3 und J!4.
- Danke, Danke, Danke: Bearbeitetes JavaScript basierend auf [VCountdown 0.0.3 | (c) 2016 Pedro Rogério | MIT License](https://github.com/pinceladasdaweb/VCountdown)

## Neue Funktionen seit Version 2021.08.10
- Kann bei der Migration von Joomla 3 nach 4 helfen, um Meta-Daten wie Meta-Beschreibungen oder Meta-Schlüsselworte zu schützen, die nach der Migration gar nicht mehr angezeigt werden oder beim Speichern von Joomla-Einträgen unerwartet verloren gehen könnten.
- Siehe Überschrift [Warum die Wiederbelebung dieses Plugins mit Joomla 4](#warum-die-wiederbelebung-dieses-plugins-mit-joomla-4) unten.
- Siehe Überschrift [Kurzanleitung bei Joomla 3-4-Migrationen für grundlegende Zwecke](#kurzanleitung-bei-joomla-3-4-migrationen-und-grundlegende-zwecke) unten.

## Andere Features
- Optional: Fügt Zeichenzähler zu einigen Text- und Textarea-Feldern im Backend hinzu. Individuell konfigurierbar.
- Optional: Hinzufügen des Attributs `required` zu einigen Feldern, um das Speichern zu blockieren, wenn das Feld leer ist.
- Bringt einen `JHtml-Helper` mit (nicht dokumentiert).

## Einschränkungen
- Dieses Plugin bringt nicht die Funktionaliäten in Joomla 4 zurück, Meta-Schlüsselworte im Frontend in die Seite einzubauen! Es bewahrt sie lediglich vor Löschung.
- **Arbeitet nur im Backend. Funktioniert nicht mit Frontend-Bearbeitung**, da keine Zeit zum Testen.
- Nicht a11y.
- Ich bin mein eigener und einziger Tester. Ich habe versucht, mein Bestes zu geben.
- Ich habe nur "mittelmäßige", langsam wachsende JavaScript-Programmierkenntnisse, wenn wir über JQuery-losen Code sprechen. Trotzdem hat das JavsScript nur eine Größe von ca. 3kB.


### Probleme, Bugs, Fragen, Vorschläge: EN oder DE
- https://github.com/GHSVS-de/plg_system_characterscounterghsvs/issues
- https://ghsvs.de/kontakt

## Warum die Wiederbelebung dieses Plugins mit Joomla 4
### Hauptsächlich: Verhinderung von Datenverlusten einiger Felder nach der Joomla-3-4-Migration

- In Eile? Siehe Überschrift [Kurzanleitung bei Joomla 3-4-Migrationen für grundlegende Zwecke](#kurzanleitung-bei-joomla-3-4-migrationen-und-grundlegende-zwecke)
- Nach der Migration befinden sich alle in Joomla 3 eingegebenen Daten noch in der Datenbank von Joomla 4.
- - Allerdings kann es bei einigen Feldern zu Datenverlusten kommen, wenn Joomla-Einträge gespeichert werden, ohne dass die betroffenen Daten vorher angepasst wurden.
- - Allerdings werden einige Daten nicht mehr in voller Länge im Joomla-4-Backend angezeigt. Wie kann man sie dann anpassen, ohne in der Datenbank suchen zu müssen?
- - Allerdings werden einige Daten gar nicht mehr angezeigt. Wie kann man sie sehen und entscheiden, ob sie noch benötigt werden, ohne in der Datenbank zu suchen, bevor man den betreffenden Joomla-Eintrag speichert?

#### Betroffen sind folgende Felder
- Alle Metabeschreibungen in Joomla-eigenen Komponenten, die länger als 160 Zeichen sind.
- Die Meta-Schlüsselworte von Menüeinträgen, die in Joomla 4 ganz entfernt wurden.
- Die Meta-Schlüsselworte der Globalen Joomla-Konfiguration, die in Joomla 4 ganz entfernt wurden.
- Die Meta-Schlüsselworte der Inhalts-Sprachen, die in Joomla 4 ganz entfernt wurden.

#### Die Idee dahinter ist

- Installieren und konfigurieren Sie das Plugin in Joomla 3. [Siehe Kurzanleitung](#kurzanleitung-bei-joomla-3-4-migrationen-und-grundlegende-zwecke)
- Führen Sie die Joomla 3-4 Migration durch.
- Alle in Joomla 3 eingegebenen Daten sind danach noch im Backend sichtbar und können bearbeitet werden. So haben Sie die Möglichkeit diese zu bearbeiten, zu kürzen oder per Copy-Paste irgendwo zu sichern ... was auch immer Ihrem Arbeitsablauf entspricht. Freiheit der Wahl...
- Schützen Sie z.B. `Meta-Beschreibungen` in Joomla 4 davor, dass sie destruktiv abgeschnitten werden, wenn sie in Joomla 3 länger als 160 Zeichen angelegt wurden.
- Weiterhin Anzeige von `Meta-Schlüsselwörtern` in Menü-Einträgen, Joomla-Konfiguration, Inhaltssprachen.
- Beim Speichern eines Joomla-Eintrags bleiben alle alten Daten erhalten, auch wenn Sie noch keine Zeit haben, sich um die betreffenden Meta-Felder zu kümmern.
- Wenn die Arbeit getan ist, wann auch immer, deinstallieren Sie das Plugin und leben Sie mit den Einstellungen und Einschränkungen von Joomla...
- ...oder lassen Sie das Plugin weiterlaufen und arbeiten Sie wie gewohnt mit den im Plugin konfigurierten Einstellungen weiter.
- Es liegt an Ihnen, wie viele Zeichen Sie pro Feld erlauben oder nur empfehlen, ob Sie einen Zeichenzähler haben wollen, der nur warnt oder weitere Eingaben blockiert und so weiter.
- Deaktivieren Sie harte Feldlängeneinstellungen (`maxlength`). Oder passen Sie sie an, indem Sie den Zähler für die betroffenen Felder und `Erforderlich` aktivieren.
- Deaktivieren Sie den nicht konfigurierbaren und restriktiven Joomla-4-Core-Zeichenzähler.
- Vermeiden Sie lästige `JLayout`-Overrides. Ja, auch das ist möglich, aber nicht wirklich flexibel zu handhaben.
- Vermeiden Sie die Programmierung eines eigenen Plugins, das ähnliche Dinge wie dieses tut. Ja, das ist auch möglich, aber wer kann das schon oder hat die Zeit und Lust dazu?

## Welche Felder können konfiguriert werden
- Auf Bearbeitungsseiten für `Joomla-Konfiguration`, `Artikel`, `Kategorie`, `Menü-Eintrag`, `Kontakt`, `Inhalts-Sprache` vom Standard-Joomla:
- - Feld <code>Meta-Beschreibung</code>
- - Feld <code>Meta-Schlüsselworte</code>
- <code>Titel/Name</code>, <code>Alias</code> nur auf Seiten, wo sinnvoll:
- - Feld <code>Titel</code> oder <code>Name</code> (letzteres bei Kontakt).
- - Feld <code>Alias</code>

### Mögliche Einstellungen für jedes Feld einzeln
- <code>Aktivierung (z.B. Einstellfeld "Meta Beschreibung")</code>: JA/NEIN. Wenn NEIN: Es wird nichts passieren. Der Joomla-Core hat die Kontrolle.
- Wenn JA: Es werden die globalen Plugin-Einstellungen verwendet:
- - `[removeCharcounter]`. Joomla's Zeichenzähler entfernen. Empfohlen: JA. Zumindest für die Joomla-3-4-Migration.
- - `[removeMaxlength]`. Entferne `maxlength`-Attribut/Beschränkung. Empfohlen: JA. Zumindest für die Joomla-3-4-Migration.
- `Feld(er) erzwingen`. Nicht immer verfügbar. Wenn JA: Erzwingt das Laden von fehlenden Feldern in Joomla 4. Z.B. `Meta-Schlüsselworte` für Menü-Einträge usw.
- `Zähler aktivieren`. Wenn JA: Der Zeichen-Zähler wird verwendet.
- - <code>maxChars</code>: Ihre empfohlene Zeichenbegrenzung.
- - <code>chopText</code>: Wenn JA: Begrenzt die Textlänge auf <code>maxChars</code> Zeichen und blockiere die weitere Eingabe. Nicht-destruktiv, wenn der aus der Datenbank geladene Text schon vorher länger als dieser Wert war. Sie werden ihn in voller Länge sehen und speichern können. Setzt ein <code>maxlength</code> Attribut oder passt ein bestehendes an.
- <code>Erforderlich</code>. Wenn JA: Das Speichern eines Eintrags wird verhindert, wenn das Feld leer ist. Die vage benannte Einstellung `Joomla-Vorgaben entscheiden` bedeutet: Das Plugin macht nichts (solange ich nicht getestet habe, was passieren kann, wenn ich ein `required`-Attribut entferne, wo Joomla es bewusst oder einfach dummerweise gesetzt hat).
- - Nicht verfügbar für die Felder `Titel/Name` und `Alias`. Sie sind immer obligatorisch.

## Kurzanleitung bei Joomla 3-4 Migrationen und grundlegende Zwecke
- Installieren und konfigurieren Sie das Plugin in Joomla 3 vor der Migration.
- - **Oder** installieren und konfigurieren Sie das Plugin in Joomla 4 nach der Migration, aber bevor Sie irgendwelche Joomla-Einträge speichern.
- Im Plugin-Tabulator `Globale Einstellungen`:
- - Setzen Sie `[removeCharcounter]` auf JA, um Joomlas restriktiven Zeichenzähler in allen aktivierten Felder zu deaktivieren.
- - Setzen Sie `[removeMaxlength]` auf JA, um Joomlas restriktive Feldlängen in allen aktivierten Felder zu deaktivieren.
- Setzen Sie in jedem Tabulator (Artikel, Kontakt ...) alle Hauptfelder (Meta-Beschreibung, Meta-Schlüsselworte ...) auf JA (= Aktivierung).
- Aktivieren Sie die Unterfelder `Forciere Feld(er)`, wo eines verfügbar ist, um Meta-Schlüsselworte-Felder anzuzeigen, die in Joomla 4 entfernt wurden.
- Einstellungen `Erforderlich` und `Zähler aktivieren` sind nicht notwendig.
