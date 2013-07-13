MyZend / Minify
=======
Version 0.9


Usage
------------
##### The view helper minifyFiles will create a uniquer minify file, which only will be generated again if you delete it.

```
$this->headLink()->appendStylesheet($this->minifyFiles($this->basePath() . '/css/login/bootstrap/*.css'));
$this->headLink()->appendStylesheet($this->minifyFiles($this->basePath() . '/css/login/account.css'));

$this->headScript()->appendFile($this->minifyFiles($this->basePath() . '/js/login/bootstrap.js'));
$this->headScript()->appendFile($this->minifyFiles($this->basePath() . '/js/login/jquery.validate.js'));
```

##### Delete all files when deploy new changes.
```
find . -name "min-*" -exec rm -rf {} \;
```

##### Ignore minified files on your repository (.gitignore)
```
min-*
```
