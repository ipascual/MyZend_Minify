MyZend / Minify
=======
Version 0.9


Usage
------------
##### Every module will have its own email templates. (Replace Application with your module name) `module/Application/config/module.config.php`

```
$this->headLink()->appendStylesheet($this->minifyFiles($this->basePath() . '/css/login/bootstrap/*.css'));
$this->headLink()->appendStylesheet($this->minifyFiles($this->basePath() . '/css/login/account.css'));

$this->headScript()->appendFile($this->minifyFiles($this->basePath() . '/js/login/bootstrap.js'));
$this->headScript()->appendFile($this->minifyFiles($this->basePath() . '/js/login/jquery.validate.js'));
```
