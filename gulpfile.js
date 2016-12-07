var gulp       = require('gulp'),
    sequence   = require('run-sequence'),
    $          = require('gulp-load-plugins')({rename: {'gulp-concat-util': 'concat'}});


// Compile SCSS files to CSS.
gulp.task('sass', function () {
  return gulp.src('./build/scss/hardwood.scss')
    .pipe($.sass())
    .pipe(gulp.dest('./dist/css'))
    .pipe($.notify("Sass Compiled!"));
});

// Watch source files for changes and compile them.
gulp.task('watch', function () {
  gulp.watch('./build/scss/**/*.scss', ['sass']);
});

// Copy required libraries to our dist files
gulp.task('copy', function () {
  gulp.src([
    'node_modules/bootstrap/dist/js/*'
  ]).pipe($.copy('dist/js', {prefix: 4}))
    .pipe(gulp.dest('./dist'));

  gulp.src([
    'node_modules/tether/dist/js/*'
  ]).pipe($.copy('dist/js', {prefix: 4}))
    .pipe(gulp.dest('./dist'));

  gulp.src([
    'node_modules/jquery/dist/jquery.min.js'
  ]).pipe($.copy('dist/js', {prefix: 3}))
    .pipe(gulp.dest('./dist'));
});

// Default task
gulp.task('default', ['watch']);
