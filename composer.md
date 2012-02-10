# What is composer.json for?
`Composer.json` defines the required libraries for a project, and allows 
projects to define metadata about themselves for package management systems

http://packagist.org/about-composer

# What use is composer?
When a project is set up, a composer file can be used to initialise the 
required dependencies. This can be more flexible than git submodules, as the 
dependency can 'float' to the latest stable version.

There are a wide variety of packages available to install, either through URLs 
embedded in a project's `composer.json` or by searching the packagist website.

http://packagist.org/

# How do I install with it?

    cd /path/to/project/;
    # this directory should contain the composer.json file
    wget http://getcomposer.org/composer.phar;
    php composer.phar install;

