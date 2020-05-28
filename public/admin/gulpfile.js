var gulp = require('gulp'),
    sass = require('gulp-sass'); 

gulp.task('sass', function(){ 
    return gulp.src('app/scss/*.+(scss|sass)')
        .pipe(sass())
        .pipe(gulp.dest('app/css'))
});

gulp.task('watch', function(){ 
    gulp.watch('app/scss/*.+(scss|sass)', ['sass']);
});