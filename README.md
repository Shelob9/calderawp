[http://localhost:8148][http://localhost:8148]
[https://calderawp.lndo.site](https://calderawp.lndo.site)



## Install
Requires:
* Lando
* Git
* Composer

Install Steps:
* `git clone  `
* `cd calderawp`
* `lando start`

Things That Need Manually Fixed:
* On start, change wp-content URL in wp-config to match localhost URL for content dir.
* When updating WordPress, apply this patch
    - https://core.trac.wordpress.org/attachment/ticket/46387/46387.3.diff
    - 


## Releasing, Github and Packagist.
The monorepo builder allows us to split each package to its own Github repo. This allows the packages to be installed via Composer.

 Merge dependencies
    -  `composer merge`
    - https://github.com/Symplify/MonorepoBuilder#1-merge-local-composerjson-to-the-root-one.
* Split packages to seperate git repos
    - `composer split`
    - https://github.com/Symplify/MonorepoBuilder#5-split-directories-to-git-repositories
* Release update
    - `composer release [version]`
    - The provided version will be use as git tag
    - https://github.com/Symplify/MonorepoBuilder#6-release-flow
* Pushing to packagist:
    - Should be automatic.
    - Not set up yet.
