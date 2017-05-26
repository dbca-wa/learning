
Learn about LESS
----------------

A LESS file is basically a CSS files which supports variables and import. A LESS file is compiled with Lessc and it generates the CSS styleheet. Read the very small Getting Started section of http://lesscss.org/ to understand the LESS variables we use in custom.less / custom_dev.less / custom_uat.less


How to install Less compiler
----------------------------

Install node/npm on your computer: https://nodejs.org/en/

It will install npm packet manager

Install less compiler globally (if you don't already have it – try to run "lessc --version" to check if you have it)

npm install -g less


How to generate the new css files
---------------------------------

From the moodle root folder:

lessc ./theme/dpawbs3/less/custom.less ./theme/dpawbs3/style/custom.css

lessc ./theme/dpawbs3/less/custom_dev.less ./theme/dpawbs3/style/custom_dev.css

lessc ./theme/dpawbs3/less/custom_uat.less ./theme/dpawbs3/style/custom_uat.css


Test your changes
-----------------

Purge the Moodle cache. You can do it from the moodle root folder:

php admin/cli/purge_caches.php
