## changelog

### version 1.4.0
- __NEW :__ function `dump()` that returns a better format debug
- __IMPROVEMENT :__ `MagratheaDebugger` improved on displaying classes and objects
- __FIX :__ `MagratheaView->Javascripts` alias to `MagratheaView->Javascript` fixed 
- __FIX :__ `magrathea.conf` compressing vars are now boolean.
- __FIX :__ `magrathea.conf` fixed saving boolean values.
- __FIX :__ `MagratheaAdmin`: generation of `created_at`/`updated_at` fields was not working...
- __FIX :__ `MagratheaAdmin`: some other fixes and quick bug solutions...
##### version 1.4.0 new features:
- __NEW :__ HTML minifier included! Function `MagratheaController->MinifyHTML()` 
Now it's possible to minify the HTMLs.
To do so, just include the attribute `minify_html` in `magrathea.conf`.
Default to `false`.
- __NEW :__ SCSS compiler and compressor included!
Now it is possible to include SCSS files.
`MagratheaView::Instance()->IncludeSCSS($css_file)` includes the file and a simple `MagratheaView::Instance()->CSS()` automatically merges the compiled code on the compressed content and does the magic as usual. So, `IncludeSCSS()` is the new thing basically.
- __NEW :__ `Default` function for controller: if there isn't a function for the `action` method, `MagratheaController` will now call a function called `Def` sending the action as argument.
- __NEW :__ `MagratheaDatabase.php.Simulate` all the function on `MagratheaDatabase`, but as a simuation, for testing purposes or whatever. Queries are saved in a file.
- __NEW :__ `bootup` now shows sh commands to fix up the folder permissions
- __NEW :__ `boot.php` to help you out on setting up a new site
- __NEW :__ new feature to download saved database backups
- __IMPROVEMENT :__ fixing deprecated constructors (some of them) for PHP 7
- __IMPROVEMENT :__ `MagratheaConfig` `$Get` alias for `$GetFromDefault`
- __FIX :__ `MagratheaConfig` fixing environment gets
- __IMPROVEMENT :__ Removing triggers for `created_at` and `updated_at` in order to use automatic mySQL commands
- __NEW :__ plugin `jquery3.3`
- __NEW :__ plugin `bootstrap4.1`
- __IMPROVEMENT :__ When saving objects with references, gets the ids
- __IMPROVEMENT :__ automatically setting `created_at` and `updated_at` in Magrathea Model
- __NEW :__ mock functions for unit test on `MagratheaDatabase`
- __IMPROVEMENT :__ `MagratheaServer` ignores displaying functions that starts with `_`
- __NEW :__ `jQuery Growl` plugin added
- __FIX :__ Function `QueryRow` inside `MagratheaModelControl` fixed (it was messed up with `QueryOne`)
- __IMPROVEMENT/FIX :__ improvements on joins from `MagratheaQuery`

#### version 1.3.3
- __NEW :__ MagratheaAdmin => archive data in new tables
- __NEW :__ MagratheaAdmin => generate and handle table backups
- __FIX :__ `MagratheaQuery` calling parent constructor in order to avoid a warning regarding null arrays. (hapenning on `MagratheaQueryInsert`, `MagratheaQueryUpdate` and `MagratheaQueryDelete` objects)

#### version 1.3.2 (minor changes)
- __IMPROVEMENT :__ cleaning up unused code
- __FIX :__ Fixing `$dbPk` protected/public permissions on MagratheaModel
- __FIX :__ Using right config files in `MagratheaImages2` plugin

#### version 1.3.1 (minor changes)
- __NEW :__ Move `changelog` to a separate file to clean up `readme`
- __IMPROVEMENT :__ `Magrathea` class with `GetVersion` function
- __IMPROVEMENT :__ move `plugins` folder one level up
- __FIX :__ Fixing issue on Magrathea Admin regarding plugin's `info.conf` directory

### version 1.3.0
- __WARNING :__ Changed the way the relations are stored in Configuration. Now one object can have more than one relation with another object (task can be related to user from two different columns, for example). So, the way relations created in MagratheaAdmin are stored changed and MagratheaAdmin can possibliy stop working for getting already stabilished relations. - to fix, check our new manual fixes section (acccessing the folder [https://github.com/PlatypusTechnology/MagratheaPHP/tree/master/documentation/manuals](documentation/manuals) on the root of this project)
- __NEW :__ `documentation/manuals` folder added for multiple use [https://github.com/PlatypusTechnology/MagratheaPHP/tree/master/documentation/manuals](here)
- __FIX :__ `MagratheaLogger` does not ends application in case of `MagratheaConfigException` (yes, it was a stupid idea, now I see)
- __NEW :__ Function `SetEnvironment`, on `MagratheaConfig`, that allows the user to dinamically change the default environment from the configuration file
- __NEW :__ Static function `Clean`, on `MagratheaQuery`, to clean a string for a query
- __IMPROVEMENT :__ more functions can act as decorator on `MagratheaDebugger`
- __IMPROVEMENT :__ table query creator always adds `utf8` collation
- __IMPROVEMENT :__ `Start()` function from models were changed to `MagratheaStart()` in order to avoid conflicts
- __IMPROVEMENT :__ `ForwardTo($action, $control)` function from `MagratheaControl` now can work if receives only `$action`
- __IMPROVEMENT :__ Controllers starting with `_` are not included in the `IncludeAllControllers` function
- __FIX + NEW :__ Magrathea Admin migrations now are based on magrathea objects, not on (considered) existing magrathea tables. This way, it gets easier to import them to a new system.
- __FIX :__ MagratheaAdmin database and environment always coming from Config
- __FIX :__ MagratheaAdmin deleting relation
- __FIX :__ MagratheaAdmin code generation improved for avoid duplication for multiple lists of same object. Now the name of the functions are based on the name and alias of the object, not on the type of the object.
- __FIX :__ start.sh fixed permissions of static folder
- __FIX :__ `$dbPk` now public accessible in `MagratheaModels`

---

#### version 1.2.2
- __FIX :__ start.sh fixed
#### version 1.2.1
- __FIX :__ MagratheaAdmin => not required plugins where throwing fatal errors. This was fixed and when a not required plugin is missing, it will display a message with a link for it to be installed.
- __FIX :__ Inifinite loop on JavaScripts include if js compression was on (js compression still does not work!)
- __IMPROVEMENT :__ silent load for MagratheaImages: do not load javascripts
### version 1.2.0
- __NEW :__ WideImage library is now part of Magrathea's libs and is always automatically loaded
- __FIX :__ MagratheaDebugger doesn't flash notices anymore
- __FIX :__ Fixed notices in Magrathea Admin 
- __IMPROVEMENT :__ Magrathea structure validation improved
- __IMPROVEMENT :__ Magrathea Images plugin fixed notices and removed WideImage load (now it is loaded from beginning)

---

### version 1.1.0
- __FIX :__ MagratheaConfig: Inifinite loop when no config file found
- __FIX :__ Infinite CSS files generation error when can't access folder for gathering CSS
- __IMPROVEMENT :__ Better PHP warning messages handling
- __IMPROVEMENT :__ Admin header now redirects to website, not to admin home
- __NEW :__ MagratheaQuery now have the function `SetRaw`, that allows direct updates, with any conditions
- __FIX :__ Admin tree validation had some wrong paths check
- __IMPROVEMENT :__ Dropzone plugin css improved

#### version 1.0.1
- Static generation fixed
- Short PHP tags support fixed
### version: 1.0
- First stable version
