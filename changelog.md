## changelog

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
