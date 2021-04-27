"use strict";
var gulp = require("gulp");
var sass = require("gulp-sass");
var sourcemaps = require("gulp-sourcemaps");
var autoprefixer = require("gulp-autoprefixer");
var importer = require("node-sass-globbing");
var plumber = require("gulp-plumber");
var browserSync = require("browser-sync").create();
var cssmin = require("gulp-cssmin");
var stripCssComments = require("gulp-strip-css-comments");
var uglify = require("gulp-uglify-es").default;
var livereload = require("gulp-livereload");
var sass_config = {
  importer: importer,
  includePaths: ["node_modules/breakpoint-sass/stylesheets/"],
};

//Uglifies javascript
gulp.task("uglify", function () {
  return gulp
    .src("js/*.js")
    .pipe(uglify())
    .on("error", function (e) {
      console.log(e);
    })
    .pipe(gulp.dest("js_min"));
});

//Compiles sass
gulp.task("sass", function () {
  gulp
    .src("./sass/**/*.scss")
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass(sass_config).on("error", sass.logError))
    .pipe(
      autoprefixer({
        browsers: ["last 2 version"],
      })
    )
    .pipe(stripCssComments({ preserve: false }))
    .pipe(cssmin())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest("./css"));
});

//Type "gulp" on the command line to watch file changes
gulp.task("default", function () {
  livereload.listen();
  gulp.watch("./sass/**/*.scss", ["sass"]);
  gulp.watch("./js/*.js", ["uglify"]);
  gulp.watch(["./css/style.css", "./**/*.twig", "./js_min/*.js"], function (
    files
  ) {
    livereload.changed(files);
  });
});
