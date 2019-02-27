🚨**WARNING:** Although open source, this theme has been developed for the [hardwood genomics website](https://hardwoodgenomics.org) only! Attempting to use it elsewhere may result in unpredictible issues.

### Installation 
- Download the file to your drupal installation ```sites/all/theme```. 
- Enable and set as default from the admin control panel.

### Development
This theme utilizes multiple technologies to be fully customizable. This is a list of tools that we used:
- [Bootstrap 4](http://getbootstrap.com) - Front end css framework.
- [NPM](https://www.npmjs.com/) - Node Package Management to manage all dependencies.
- [SASS](http://sass-lang.com/) - css preprocessor that allows the use of variables, conditionals, etc.
- [Gulp](http://gulpjs.com/) - to automate the workflow.
- For a list of dependencies, review the [package.json](https://github.com/statonlab/hardwood/blob/master/package.json) file.

#### Gulp Commands
- ```gulp sass``` Compile sass files that are located in build/scss to css files dist/css.
- ``` gulp watch ``` Watch file changes and compile everything upon save.
- ```gulp copy``` Copy js and css files of other libraries from node_modules to the dist folder.
