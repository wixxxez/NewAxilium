var gulp        = require('gulp');
var livereload = require('gulp-livereload');
var sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');

gulp.task('livereload', function () {

  gulp.src('./media/css/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(gulp.dest('./media/css/'))
    .pipe(livereload());

});

gulp.task('default', function() {
  livereload.listen();
  gulp.watch('./media/css/*.scss', ['livereload']);
});