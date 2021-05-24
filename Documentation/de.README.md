# TYPO3-Extension "simpledataedit"
## Vorwort
Wenn man als Chemiker systematisch untersuchen möchte, welchen Einfluß bestimmte 
Reaktionsbedingungen auf den Ablauf einer chemischen Reaktion haben, dann braucht man dafür das Ergebnis einer Vielzahl 
von durchgeführten Synthesen in vielen verschiedenen Variationen.
Für die statistische Synthesen sollten die Ergebnisse der Reaktionen in einer Datenbank abgelegt sein. 
Nun führen weltweit viele Studenten im Studium ähnliche einfache Reaktionen unter verschiedenen Bedingungen durch.
Es wäre also cool, wenn die Studenten die verschiedeben Beobachtungen und Rahmenbedingungen ihrer Synthesen in eine Datenbank eingeben würden. 
Im Idealfall wäre die Eingabemaske so aufgebaut, dass mit jeder weitere Eingabe das Synstheseprotokoll der Studenten Form annimmt.
Die Studenten würde für ihre Eingabe ein fertige Protokoll erhalten, dass sie nicht mehr selbst schreiben müssten. 
Mit simpledataedit stellt die  Basis für eine dynamisches Eingabe-Maske dar, die dafür sogt, dass die Daten gemäß der Regeln der datenbanknormalisierung abgelegt werden.
Dies erklärt vielleicht auch, warum mit die Übersetzungen und Richt-Text-Anwendungen relativ egal sind.  


#### Version: 20210418
#### Vorbemerkung 
Beim Erstellen der Dokumentation ist die deutsche Version führend. 
Die englische Version wird mittels des Google-Translator immer nachrangig erstellt. Der Vergleich des Versionsdatum erlaubt die Prüfung, ob die Übersetzung dem aktuellen Stand entspricht.

####Prolog Hilfssatz für Schreiberlinge
Eine guter Zeitungsartikel skizziert im ersten Absatz/Satz folgenden Merksatz der Informationsbedürfnisse:
- Wer tut was mitWem/womit wann, wo und wie? 
- Das Warum im zweiten Absatz ist wie der 2. Hauptsatz der Thermodynamik immer Glaubenssache?
- Wer falsche Fragen stellt, bekommt auch mit tausend Forschern und Milliarden für die Forschung immer nur eines: falsche Antworten! (*Wie stark treibt Kohlenstoffdioxid den Klimawandel voran? Ich glaube, dass ist eine falsche Frage. Statt `stark` wäre `minimal` treffender.* ;-)

## Wer tut was mitWem/womit wann, wo und wie?
Die Extention speichert einfache Text-Änderungen 
in editierbaren Bereichen des Frontends der Webseite 
direkt in der Datenbank via Ajax/JavasScript,
wenn der Redakteur gleichzeitig im Backend eingeloggt ist und 
wenn der Integrator dies in den Templates vorgesehen hat.
So kann der  Redakteur direkt einfache Text-Änderungen
im Frontend vornehmen und seine WYSIWYG-Gefühle genießen.

Technisch gesehen definiert die Extension nur das Abdäten eines einzelnen Feldes
in einer bestimmten Datenbank bei einem bestimmten Datensatz mit Hilfe eines verallgemeinerten AJAX-Prozesses.
Durch einen Hashwert für jeden Datensatz wird gewährleistet, dass die Änderung immer auf dem gerade vorher gesehenen Text beruht. 
Mehrere Redakteure können sich nicht unwissentlich(!) gegenseitig die Texte überschreiben.  


## Wie arbeitet der Redakteur arbeiten?

1. Der Redakteur loggt sich im Backend der Webseite ein.
2. Er öffnet in einem zweiten Tab des Browser die Frontend-Ansicht der Webseite.
3. Die editierbaren Bereiche sind farblich hervorgehoben.
4. Falls er eine Fehlermeldung bekommt, muss der Redakteur das Frontend im Browser neu laden.

### Technische Voraussetzungen?
- ein moderner Browser

### Was geht aktuell nicht?
Von CRUDE (Create, Read, Update, Delete, Edit) geht aktuell eingeschränkt nur RUE.

1. In Multi-Domain-Aufsetzungen werden die BE_TYPO3_USER-Cookies nur in der aktuellen Domain
gesetzt, in welcher sich der Redakteur eingeloggt hat. Wenn man in der Domain B etwas ändern will, muss man über die Domain B auch im Backend eingeloggt sein.
2. Formalisierte Felder des Backends wie RTE-Felder, Datumsfelder oder wie in f:translate eingebettete Daten lassen sich bisher(!) nicht editieren.
3. Das Ändern von Relationen (Bilder, ähnliche Nachrichten, ...) wird derzeit nicht unterstützt.
4. Das Neuanlegen oder Löschen von Datensätzen wird nicht unterstützt.
5. Das Ändern von Daten in Attributen oder von leeren, nichtangezeigten Datenfeldern.

### Was könnte/sollte es in Zukunft geben?
Bei den folgenden Punkten hoffe ich auf die Community:
1. Formalisierte Felder machen den Editierprozess komplexer. 
   Dies sollte sich mit neuen Editor-Klassen erledigen lassen.
   Die Extension erlaubt die Definition und Einbindung von  `Editor`-Klassen.
2. Das Ändern von Relationen braucht spezielle Methoden im Frontend und einen verallgemeinerten Prozess im Backend.
   Dies sollte sich mit neuen Editor-Klassen erledigen lassen.
   Die Extension erlaubt die Definition und Einbindung von  `Editor`-Klassen.
3. Das Ändern von Daten in Attributen oder von leeren, nichtangezeigten Datenfeldern
   Dies sollte sich mit neuen Editor-Klassen erledigen lassen.
   Die Extension erlaubt die Definition und Einbindung von  `Editor`-Klassen.
   
Bei den anderen Punkten ist ein leichtes Umdenken der Entwickler erforderlich.
Dies wird aber vom Entwickler vorangetrieben werden.
1. Das Neuanlegen und Löschen von Datensätzen wird nicht unterstützt. 
2. Das Neuanlegen und Löschen von neuen Relationen zu bestehenden Datensätzen wird nicht unterstützt.
3. Das Neuanlegen und Löschen von neuen Relationen zu neu zu schaffenden Datensätzen wird nicht unterstützt.
4. Die Zahl der Angaben beim Viewhelper systematisch reduzieren, was die Sicherheit durch Obsurität erhöht. 

Warum ist Umdenken erforderlich? (Ich schließe hier mal von mir auf andere.) Im TYPO3-Backend wird eine Datensatz erst geschaffen, wenn er explizit gespeichert wird. Die erlaubt vorm Speichern den Datensatz zu Editieren. 
Beim hier vorgestellten Konzept muss man dagegen einen Default-Datensatz schaffen. 
Vermutlich muss man auch die Seite neu laden, um alle editierbaren Felder 
verfügbar zu haben. Man muss also sich tiefergehend als bisher Gedanken machen, 
welche Daten ein initialer Datensatz enthalten muss und dies nicht nur in der TCA sondern auch im Modell verankern.     

## Was muss der Integrator machen

### Aktueller Status
Aktuell werden nur trimmbare PlainText-Felder unterstützt.
Der Integrator muss nur die ensprechenden Datenfelder mit dem Viewhhelper
`<simpledataedit:editor ...>` einschließen.

### Beispiele
Es gibt die Beispiel-Extension *simpledataedittest*.

### Styles und JavaScript anpassen
In den Settings der Extension ist der Pfad zur JavaScript-Datei 
und zur Datei der CSS-Styles angegeben. 
Durch Überschreiben der Definition kann der Entwickler eine eigene Datei einbinden.

## Was ist das Arbeitsprinzip der Extension? Wie ist der Workflow?
Das Arbeitsprinzip ist einfach.
Der Viewhelper hinterlegt im Frontend alle Daten für das Frontend-Editing.
Bei Fontendrendering werden auch die JavaScript-Funktionen der Editoren gerendert und 
die grundsätzlichen JavaScript-Bibliotheken für den Ajax-Prozess eingebunden.
Sobald man ein verändertes Feld (focusout) verlässt, wird der Ajax-Prozess gestartet 
und in einer Middleware verarbeitet.

Im Fehlerfall schreibt der Ajax-Prozess eine Fehlermeldung mit dem Hinweis zum Redirekt.
im Erfolgsfall wird der neue Hashwert zurückgeliefert.

## Parameter des Viewhelpers
Die grundsätzlichen Viewhelper-Attribute stehen auch in `<simpledataedit:editor ...>` zur Verfügung.

Parameter | Type    | Default    | Funktion
--------- | ------- | ------- | ------------------------------------------------------
editor | string | *pflicht* |           Kennung für angepasste Editor-Prozessor-Klasse |
pid | int | *pflicht* |                 Seiten-ID, wo das Inhaltselement angezeigt wird. |
raw | string | *pflicht* |              Dies enthält die Rohdaten. Es ist die Basis für den Hash-Wert.  |
Feldname | Zeichenfolge | *pflicht* |   Name des Feldes im Modell. Es kann fehlen, wenn ein angepasster Prozess einen selbst definierten Abruf- und Aktualisierungsprozess verwendet, um die Daten abzurufen.  |
uid | int | *pflicht* |                 Nummer der UID, die die Zeile im Modell durch das UID-Feld angibt. Es kann fehlen, wenn ein angepasster Prozess einen selbst definierten Abruf- und Aktualisierungsprozess verwendet, um die Daten abzurufen.  |
Typ | Int | 2 |                         Name des Typs des Werts (int=1, str=2, bool=5) für das Feld im Modell. Es kann fehlen, wenn ein angepasster Prozess einen selbst definierten Abruf- und Aktualisierungsprozess verwendet, um die Daten abzurufen.  |
Tabelle | Zeichenfolge | 'tt_content' | Name des Modells. Es kann fehlen, wenn ein angepasster Prozess einen selbst definierten Abruf- und Aktualisierungsprozess verwendet, um die Daten abzurufen.  |
identname | string | 'uid' |            Name des Identfelds, mit dem die Zeile im Modell angegeben wird. Es kann fehlen, wenn ein angepasster Prozess einen selbst definierten Abruf- und Aktualisierungsprozess verwendet, um die Daten abzurufen.  |
paramList | string | "[]" |             Eine Liste von Argumenten für angepasste Parsing-Prozesse im Array-Format. Es wird in einen JSON-String konvertiert  |
Rollen | String | *undef* |             Die durch Kommas getrennte Liste von Benutzergruppen mit ihrer UID und / oder ihrem Titel). |
immer | bool | false |                  Erlaube immer die Frontend-Bearbeitung für alle. Die Zulage muss in der Erweiterungskonfiguration freigegeben werden  |

## Was können Entwickler tun
### Erstellen eines eigenen Editors
Eine Editor-Klasse muss die Funktionen des Interface `CustomEditorInterface` bereitstellen.
Der Transfer der Parametern wird über eine Klasse `CustomEditorInfo` realisiert, 
die sich von dem Interface `EditorArgumentsInterface` ableitet.
Aktuell ist es nicht möglich, die `CustomEditorInfo` durch eine eigenen Klasse übersteuern zu lassen. 

### Einbau der eigener Editor-Klassen für besondere Anwendungen
In der Beispielextension wird die Code-Kopie von PlainTextEditor als eigene Klasse eingebaut.
Wenn sie ihre Klasse *MyVendor\MyExtension\Editor\MyEditor* definiert haben, muss diese natürlich dem System noch bekannt gegeben werden. 
Definieren sie in ihrer `ext_localconf.php` folgenden Code-Block:
```
  /**
     * define your own editor-class, if you have special elements
     */
    $whoAmI = 'whoAmI';  // if i use the name directly, PHPStorm remarks it with a warning ;-(
    $listOfCustomEditorClasses = [
        \MyVendor\MyExtension\Editor\MyEditor::$whoAmI() =>
            \MyVendor\MyExtension\Editor\MyEditor::class,
    ];
    \Porthd\Simpledataedit\Utilities\ConfigurationUtility::mergeCustomGlobals(
        $listOfCustomEditorClasses
    );
```
Die statische Methode sorgt dafür, daß ihre Klassenname in $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['simpledataedit']['editor']['editor']['Ihr-whoAmI-Name'] eingetragen wird.
Um die Wahrscheinlichkeit von ungewollten Überschreibungen zu vermeiden, sollte ihr whoAmI-Name ihren vendor-Namen enthalten. 


## To Do
1. Cache für referenzierte Seiten und Datensätze. ( ein großes Problem) 
1. Ich habe bisher nicht verstanden, wie man Cross-Domain-Cookie setzen könnte.
   Oder wie man einfach einen OAuth-Prozess realisiert.
   Anregungen mit Code-Beispielen werde ich gern übernehmen.
1. Es wäre wünschenswert, wenn Simpledataedit folgenden unterstützen würde
   - Datum und Uhrzeiten im Datetime-Format
   - Datum und Uhrzeiten im UNIX-Timestamp-Format (integer)
   - Komma-Zahlen
   - Editieren von Daten, die in Translate-Felder integriert sind. 
1. Generalisierte Abfragen für das Anlegen/Löschen/Verändern von einfachen Relationen
1. Generalisierte Abfragen für das Anlegen/Löschen/Verändern von MM-Relationen
1. Löschen von Relationen und Schaffen neuer Default-Objekte
