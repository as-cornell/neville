const gulp = require('gulp');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();
const autoprefixer = require("gulp-autoprefixer");
// const cssmin = require("gulp-cssmin");
const sassGlob = require('gulp-sass-glob');
const terser = require('gulp-terser');
const cssnano = require('gulp-cssnano');

const sourcemaps = require('gulp-sourcemaps');

const config = {
  scss: './scss/**/*.scss',
  cssDir: './css',
  cssFiles: './css/*.css',
  jsDir: './js',
  jsMinDir: './js_min',
  jsFiles: './js/*.js'
};



//compile scss into css
// 1. init sourcemaps
// 2. glob scss
// 3. Sassify
// 4. autoprefixer
// 5. write sourcemaps to same dir as css
// 6. minifiy css
// 7. write to /css

function sassProcessor() {
  return gulp.src(config.scss)
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.identityMap())
    .pipe(sassGlob())
    .pipe(sass()).on('error', sass.logError)
    .pipe(autoprefixer({ browsers: ["last 2 version"] }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./css'))
  .pipe(browserSync.stream());
}

async function jsProcessor() {
  return gulp.src('./js/*.js')
    .pipe(terser())
  .pipe(gulp.dest('./js_min'));
}

// Still need to work cssmin or cssnano into the mix.

function watch() {
  browserSync.init({
    proxy: 'http://appserver_nginx.neville.internal',
    socket: {
      domain: 'https://bs.neville.lndo.site/',
      port: 80
    },
    open: false,
    logLevel: "debug",
    logConnections: true,
  });
  gulp.watch(config.scss, sassProcessor);
  gulp.watch(config.jsDir, jsProcessor);
  gulp.watch('./**/*.twig').on('change', browserSync.reload);
}


exports.sassProcessor = sassProcessor;
exports.jsProcessor = jsProcessor;
exports.watch = watch;