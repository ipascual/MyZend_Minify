MyZend / Minify
=======
Version 0.9


Usage
------------
##### The view helper minifyFiles will create a uniquer minify file, which only will be generated again if you delete it.

```
// Single file
$this->headScript()->appendFile($this->minifyFiles($this->basePath() . '/js/login/bootstrap.js'));
$this->headScript()->appendFile($this->minifyFiles($this->basePath() . '/js/login/jquery.validate.js'));

// Group files, you can control files order
$this->headLink()->appendStylesheet(
							$this->minify(
								array(
									$this->basePath() . '/css/bootstrap/bootstrap.css',
									$this->basePath() . '/css/bootstrap/bootstrap-responsive.css',
									$this->basePath() . '/css/animate.css',
									$this->basePath() . '/css/main.css'
								)
							)
						);

// Wildcard way 
$this->headLink()->appendStylesheet($this->minifyFiles($this->basePath() . '/css/login/bootstrap/*.css'));

// Other options
$this->headLink()->appendStylesheet(
							$this->minify(
								array(
									$this->basePath() . '/css/bootstrap/*.css',
									$this->basePath() . '/css/animate.css',
									$this->basePath() . '/css/main.css'
								)
							)
						);
```

##### Delete all files when deploy new changes.
```
find . -name "min-*" -exec rm -rf {} \;
```

##### Ignore minified files on your repository (.gitignore)
```
min-*
```
