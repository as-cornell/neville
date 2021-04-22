const gulp = require('gulp');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();
const autoprefixer = require("gulp-autoprefixer");
const cssmin = require("gulp-cssmin");
const sassGlob = ('gulp-sass-glob');
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
    // init sourcemaps
  
    .pipe(sourcemaps.init())
  // 2 pass that file to sass compiler
    .pipe(sass()).on('error', sass.logError)
  // auto prefix
    .pipe(autoprefixer({ browsers: ["last 2 version"] }))
    

    // write sourcemaps
    .pipe(sourcemaps.write('.'))
  // 3 where do they go?
    .pipe(gulp.dest(config.cssDir))
}

// minify and send to /css_min
function cssProcessor() {
  return gulp.src(config.cssFiles)
    .pipe(cssmin())
  .pipe(gulp.dest(config.cssMin))
}



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