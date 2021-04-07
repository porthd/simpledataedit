# TYPO3 extension "simpledataedit"

#### Prologue auxiliary sentence for scribes
A good newspaper article outlines the following motto of information needs in the first paragraph/sentence:
- Who does what with whom/with what when, where and how?
- The why in the second paragraph, like the 2nd law of thermodynamics, is always a matter of belief?
- Anyone who asks the wrong questions will always get one thing for sure: wrong answers! ( *I hope I haven't answered too many wrong descriptive questions here.* ;-)


## Who does what with whom/with what, when, where and how?
The extension saves simple text changes
in editable areas of the front end of the website
directly in the database via Ajax/JavasScript,
if the editor is logged into the backend at the same time and
if the integrator has provided for this in the templates.
In this way, the editor can make simple text changes directly
in the frontend and enjoy your WYSIWYG feelings.

From a technical point of view, the extension only defines the sealing off of a single field
in a specific database at a specific record using a generalized AJAX process.
A hash value for each data record ensures that the change is always based on the text just seen before.
Several editors cannot unknowingly (!) Overwrite each other's texts.


## How does the editor work?

1. The editor logs into the backend of the website.
2. He opens the frontend view of the website in a second tab of the browser.
3. The editable areas are highlighted in color.
4. If he gets an error message, the editor has to reload the frontend in the browser.

### Technical requirements?
- a modern browser

### What is not working?
From CRUDE (Create, Read, Update, Delete, Edit), only RUE is currently limited.

1. In multi-domain setups, the BE_TYPO3_USER cookies are only used in the current domain
   in which the editor has logged in. If you want to change something in domain B, you have to be logged into the backend via domain B.
2. Formalized fields of the backend such as RTE fields, date fields or data embedded in f: translate cannot yet (!) Be edited.
3. Changing relations (pictures, similar messages, ...) is currently not supported.
4. The creation or deletion of data records is not supported.
5. Changing data in attributes or empty, undisplayed data fields.

### What could happen in the future?
I hope for the community on the following two points:
1. Formalized fields make the editing process more complex.
   This should be able to be done with new editor classes.
   The extension allows the definition and integration of `Editor` classes.
2. Changing relations requires special methods in the front end and a generalized process in the back end.
   This should be able to be done with new editor classes.
   The extension allows the definition and integration of `Editor` classes.
3. Changing data in attributes or empty, undisplayed data fields
   This should be able to be done with new editor classes.
   The extension allows the definition and integration of `Editor` classes.

The other two points require a slight rethink on the part of the developers.
1. The creation and deletion of data records is not supported.
2. The creation and deletion of new relations to existing data records is not supported.
3. The creation and deletion of new relations to new data records to be created is not supported.

Why is it necessary to rethink? (I'm inferring from myself to others.) In the TYPO3 backend, a data record is only created when it is explicitly saved. This allows the data record to be edited before saving.
With the concept presented here, on the other hand, you have to create a default data record.
You probably have to reload the page to see all editable fields
available. So you have to think more deeply than before,
which data an initial data record must contain and anchor this not only in the TCA but also in the model.

## What does the integrator have to do
Currently only trimmable plain text fields are supported.
The integrator only has to enter the corresponding data fields with the Viewhhelper
Include `<simpledataedit: editor ...>`.

### Is there a sample code for integrators?
In order to enable a trouble-free test in a live system and a classic form of extension upload,
the extension has its own backend layout.
In order to be able to use this for the test, the exemplary TypoScript must also be integrated.

The backend layout defines a test column with the ColPos value (7387).
After activating the test TypoScript of this extension, a test page in the column (7387)
made the `header` field editable in a special template for the TYPO3` text-only` content element.
(see code *simpledataedit/Resources/Private/Templates/FluidElements/Text.html* )

### Customize styles
The path to the JavaScript is in the settings of the extension
and given to the styles.

## What is the working principle of the extension? How is the workflow?
The working principle is simple.
The Viewhelper stores all data for frontend editing in the frontend.
With font rendering, the JavaScript functions of the editors are also rendered and
the basic JavaScript libraries for the Ajax process are integrated.
As soon as you leave a changed field (focusout), the Ajax process is started
and processed in a middleware.

In the event of an error, the Ajax process writes an error message with a note on redirection.
if successful, the new hash value is returned.

## Parameters of the view helper
The basic viewhelper attributes are also available in `<simpledataedit: editor ...>`.

Parameters | Type | Default | function
--------- | ------- | ------- | --------------------------------------------------
editor | string | *mandatory* | Identifier for adapted editor processor class 
pid | int | *mandatory* | Page ID where the content item is displayed. 
raw | string | *mandatory* | This contains the raw data. It is the basis for the hash value. 
Field name | String | *mandatory* | Name of the field in the model. It may be absent if a custom process uses a self-defined get and update process to get the data. 
uid | int | *mandatory* | Number of the UID that specifies the line in the model through the UID field. It may be absent if a custom process uses a self-defined get and update process to get the data. 
Type | Int | 2 | Name of the type of value (int = 1, str = 2, bool = 5) for the field in the model. It may be absent if a custom process uses a self-defined get and update process to get the data. 
Table | String | 'tt_content' | Name of the model. It may be absent if a custom process uses a self-defined get and update process to get the data. 
identname | string | 'uid' | Name of the ident field with which the line is specified in the model. It may be absent if a custom process uses a self-defined get and update process to get the data. 
paramList | string | "[]" | A list of arguments for custom parsing processes, in array format. It is converted to a JSON string 
Roles | String | *undef* | The comma-separated list of user groups with their UID and/or their title). 
always | bool | false | Always allow front-end editing for everyone. The allowance must be released in the expansion configuration |

## What can developers do
### Create your own editor
An editor class must provide the functions of the interface `CustomEditorInterface`.
The parameters are transferred via a `CustomEditorInfo` class,
which is derived from the interface `CustomEditorInfoInterface`.
It is currently not possible to override the `CustomEditorInfo` with a separate class.

### Example for editor class
see in the code *simpledataedit/Classes/Editor/PlainTextEditor.php*

### Installation of the editor class in its own extension
If you have defined your class *MyVendor\MyExtension\Editor\MyEditor*, this must of course still be made known to the system.
Define the following code block in your `ext_localconf.php`:
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
The static method ensures that your class name is entered in $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['simpledataedit']['editor']['editor'] ['your-whoAmI-name'].
To avoid the likelihood of unwanted overwrites, your whoAmI name should contain your vewndor name.

## To do
1. Cache for referenced pages and records. ( a big problem) 
1. I have not yet understood how to set cross-domain cookies.
   Or how to simply implement an OAuth process.
   I will gladly accept suggestions with code examples.
1. It would be desirable if Simpledataedit would support the following
   - Date and time in datetime format
   - Date and time in UNIX timestamp format (integer)
   - comma numbers
   - Editing of data integrated in translate fields.
1. Generalized queries for creating/deleting/changing simple relations
1. Generalized queries for creating/deleting/changing MM relations
1. Deleting relations and creating new default objects