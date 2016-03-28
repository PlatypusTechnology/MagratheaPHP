# MagratheaPHP
PHP Framework developed and used by Platypus Technology

![Magrathea](https://raw.githubusercontent.com/PlatypusTechnology/MagratheaPHP/master/documentation/logo/magrathea.png)

For documentation:
[http://magrathea.platypusweb.com.br/](http://magrathea.platypusweb.com.br/)

Start developing with Magrathea now!

```
git clone https://github.com/PlatypusTechnology/MagratheaPHP/
cp -rv MagratheaPHP/Magrathea/* .
rm -rf MagratheaPHP
```

## changelog

#### version 1.2.0
- __NEW :__ WideImage library is now part of Magrathea's libs and is always automatically loaded
- __FIX :__ MagratheaDebugger doesn't flash notices anymore
- __FIX :__ Fixed notices in Magrathea Admin 
- __IMPROVEMENT :__ Magrathea structure validation improved
- __IMPROVEMENT :__ Magrathea Images plugin fixed notices and removed WideImage load (now it is loaded from beginning)

#### version 1.1.0
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

#### version: 1.0
- First stable version



