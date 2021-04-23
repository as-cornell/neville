const gulp = require('gulp');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();
const autoprefixer = require("gulp-autoprefixer");
const cssmin = require("gulp-cssmin");
const sassGlob = require('gulp-sass-glob');
const stripCssComments = require("gulp-strip-css-comments");

const sourcemaps = require('gulp-sourcemaps');


// HEY Bob need to install autoprefixer and cssnano instead of the gulp versions to use with postcss
// https://stackoverflow.com/questions/40090111/postcss-error-object-object-is-not-a-postcss-plugin

// const autoprefixer = require ('autoprefixer');


const config = {
  scss: './scss/**/*.scss',
  cssDir: './css',
  cssFiles: './css/*.css',
  cssMin: './css_min'
};



//compile scss into css
function sassProcessor() {
  // 1 where is css
  return gulp.src(config.scss)
    
    .pipe(sourcemaps.init())
    .pipe(sassGlob())
    .pipe(sass()).on('error', sass.logError)
    .pipe(autoprefixer({ browsers: ["last 2 version"] }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(config.cssDir))
}

// minify and send to /css_min
function cssProcessor() {
  return gulp.src(config.cssFiles)
    .pipe(cssmin())
  .pipe(gulp.dest(config.cssMin))
}

// need to run cssmin on /css. setting the library up to look at /css_min breaks source maps. must be in same directory as the css being used.

function watch() {
  browserSync.init({
    server: {
      baseDir: './'
    }
  });
  gulp.watch(config.scss, sassProcessor);
  gulp.watch(config.cssFiles, cssProcessor);
  gulp.watch('./*.html').on('change', browserSync.reload);
}


exports.sassProcessor = sassProcessor;
exports.cssprocessor = cssProcessor;
exports.watch = watch;