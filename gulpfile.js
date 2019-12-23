const gulp = require('gulp');
const exec = require('child_process');
const sass = require('gulp-sass');
const concat = require('gulp-concat');
const watch = require('gulp-watch');
const sourcemaps = require('gulp-sourcemaps');
const minify = require('gulp-minify');
const cleancss = require('gulp-clean-css');
const fs = require('fs');

gulp.task('sass', function() {
  gulp.src('./source/sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./theme'));
});

gulp.task('css', function() {
  gulp.src('./source/css/**/*.css')
    .pipe(cleancss())
    .pipe(gulp.dest('./theme/assets/css'))
});

gulp.task('js', function() {
  gulp.src([
    './source/js/navigation.js',
    './source/js/skip-link-focus-fix.js',
    './source/js/main.js',
    './source/js/slick.min.js',
    './source/js/isotope.pkgd.min.js',
  ])
    .pipe(concat('main.js'))
    .pipe(minify())
    .pipe(gulp.dest('./theme/assets/js'))
});

gulp.task('deploy', function() {
  //exec.execSync('mkdir -p theme/assets/css theme/assets/js');
  console.log(exec.execSync('sh rsync.sh').toString());
  //console.log(exec.execSync('DYLD_LIBRARY_PATH=./lftp ./lftp/lftp -f ./lftp/lftp.cmd').toString());
});



gulp.task('default', function() {
  //gulp.watch(['./theme/**/*','!./theme/style.css','!./theme/assets/js/*.js'], ['deploy']);
  gulp.watch('./theme/**/*', ['deploy']);

  gulp.watch('./source/sass/**/*.scss', ['sass']);
  gulp.watch('./source/css/**/*.css', ['css']);
  gulp.watch('./source/js/**/*.js', ['js']);

  gulp.start('sass');
  gulp.start('css');
  gulp.start('js');
});

