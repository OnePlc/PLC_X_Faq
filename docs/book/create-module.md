# Create Module based on blog

In this tutorial we'll show you how you can create your 
own onePlace Module based on Blog.

In this example we gonna make a module called "Blog",
which allows us to manage our blog library.

As onePlace is opensource, and we want to encourage you to 
also work under an open licence, we will use composer in this
tutorial for packaging and distributing the module. 

if you plan to make an closed source project / module, you will
need other ways to install & autoload your module in oneplace than
the open composer infrastructure. we will provide tutorials for this
also at a later point.

## The bootstrap script

As you can see in `data\createmodulefromblog.ps1` and `data\createmodulefromblog.sh` we are
currently working on a bootstrap script, that will do most of the work
described here for you. 

So this tutorial is for those who want a technical understanding of the process
and also for those who want to start before the scripts are finished which can
take a couple of weeks.

## Getting started (manual process)

So lets start to create our new module "Blog".

* Go to [https://github.com/OnePlc/PLC_X_Blog/releases](https://github.com/OnePlc/PLC_X_Blog/releases) and download the latest release of oneplace-blog
* Unpack the files to your destination folder
* Open the project with your desired editor (we recommend [PHPStorm](https://www.jetbrains.com/phpstorm/))
* Search and Replace within the whole project directory for the following terms (without """)

> (Example) "SearchFor" - "ReplaceWith" (MUST be case-sensitive)

> "Blog" - "Blog"

> "blog" - "blog"

* Rename all necessary files and folders
```
.
+-- src
|   +-- Controller
|   |   +-- BlogController.php
|   +-- Model
|   |   +-- Blog.php
|   |   +-- BlogTable.php
+-- test
|   +-- Controller
|   |   +-- BlogControllerTest.php
+-- view
|   +-- layout
|   |   +-- blog-default.phtml
|   +-- one-place
|   |   +-- blog
|   |   |   +-- blog
|   |   |   |   +-- add.phtml (edit/view/index)
```
* so you will end up with something like
```
.
+-- src
|   +-- Controller
|   |   +-- BlogController.php
|   +-- Model
|   |   +-- Blog.php
|   |   +-- BlogTable.php
+-- test
|   +-- Controller
|   |   +-- BlogControllerTest.php
+-- view
|   +-- layout
|   |   +-- blog-default.phtml (optional - you can also delete it)
|   +-- one-place
|   |   +-- blog
|   |   |   +-- blog
|   |   |   |   +-- add.phtml (edit/view/index)

```

Done - you finally have a working "Blog" Module for onePlace !

Now, lets see how we can add this module to onePlace

## Packaging and distribution

For opensource projects, you can use [packagist.org](https://packagist.org) and [composer](https://getcomposer.org)
to package and distribute your package. Also composer handles autoloading and integration
of your new "Blog" module into onePlace.

Before you start, check `composer.json` within your "Blog" module directory and 
make all changes you want to the file for publishing (like change name, customize description and so on)

* Publish your module on [github.com](https://github.com) with an open licence
* Go to [packagist.org](https://packagist.org) and submit your new module
* Add your new package to oneplace with composer as shown on packagist.org

Your new module is now available in onePlace ! As with Blog, go to /update and perform
the updates to run your `install.sql` so your module "Blog" is fully installed in onePlace!

Congrats and have Fun with your new module