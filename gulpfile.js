'use strict';

var gulp = require('gulpfile');
var sass = require('gulp-sass');
var minify = require('gulp-minify');
var cleanCss = require('gulp-clean-css');

/**
 * Compress css to min.css
 */
gulp.task('minify-css', function() {
    return gulp.src('styles/*.css')
        .pipe(cleanCss({compatibility: 'ie8'}))
        .pipe(gulp.dest('dist'));
});

/**
 * Compress js to min.js
 */
gulp.task('compress', function() {
    gulp.src('lib/*.js')
        .pipe(minify({
            ext:{
                src:'-debug.js',
                min:'.js'
            },
            exclude: ['tasks'],
            ignoreFiles: ['.combo.js', '-min.js']
        }))
        .pipe(gulp.dest('dist'))
});

/**
 * Compile scss to css
 */
gulp.task('sass', function () {
    return gulp.src('./web/bundles/*/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./web/bundles/*/css'));
});

/**
 * Watch for changes in files and trigger build process
 */
gulp.task('watch', function () {
    gulp.watch('./web/bundles/*/sass/**/*.scss', ['sass']);
});

/**
 * Default task
 */
gulp.task('default', ['sass']);
