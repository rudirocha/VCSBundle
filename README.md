# VCSBundle
A Version Control Bundle for development helping.

## GIT
Git is the only (for now) version control system implemented

#### Features
* Branch name at toolbar
* Toolbar info with current user name and email + remote origin URL + File change counter
* Profiller page with all files changed
* Profiller page with branch list for checkout

## Instalation steps
* Install by composer

 > composer require rudirocha/vcs-bundle
* Add it at your AppKernel.php

 > ...
 
 > new Rubius\VCSBundle\RubiusVCSBundle(),
 
 > ...
 
* Make sure your config.yml has translation fallback available

## Next Steps

* Add translations
* Enable more "point and click" actions for git management
