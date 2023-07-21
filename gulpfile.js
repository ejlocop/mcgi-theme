var gulp        = require('gulp');
var banner      = require('gulp-banner');
var cleanCSS    = require('gulp-clean-css');
var cssbeautify = require('gulp-cssbeautify');
var concat      = require('gulp-concat');
var rename      = require('gulp-rename');
var scss        = require('gulp-sass');
var uglify      = require('gulp-uglify');
var pkg         = require('./package.json');

var comment = '';

var assetsConfig = {
	app: 'app',
	srcPath: {
		js:   './assets-src/js/',
		scss: './assets-src/scss/'
	},
	targetPath: {
		js:   './assets/',
		scss: './assets/'
	}
}

gulp.task('scss--app', function() {
	return gulp.src(assetsConfig.srcPath.scss + assetsConfig.app + '/app.scss')
		.pipe(scss({outputStyle: 'expanded'}).on('error', scss.logError))
		.on('error', logError)
		.pipe(cssbeautify())
		.pipe(rename('app.css'))
		.pipe(gulp.dest(assetsConfig.targetPath.scss))
		.pipe(cleanCSS())
		.pipe(rename('app.min.css'))
		.pipe(banner(comment, {
			pkg: pkg
		}))
		.pipe(gulp.dest(assetsConfig.targetPath.scss));
});

gulp.task('scss', gulp.series('scss--app'));

gulp.task('uglify--app', function() {
	return gulp.src([
			// assetsConfig.srcPath.js + assetsConfig.app +'/helpers.js',
			assetsConfig.srcPath.js + assetsConfig.app +'/app.js',
		]) 
		.pipe(concat('app.js'))
		.pipe(gulp.dest(assetsConfig.targetPath.js))
		.pipe(uglify())
		.on('error', logError)
		.pipe(rename('app.min.js'))
		.pipe(banner(comment, {
			pkg: pkg
		}))
		.pipe(gulp.dest(assetsConfig.targetPath.js));
});

gulp.task('uglify', gulp.series('uglify--app'));

gulp.task('watch', function() {
	gulp.watch(assetsConfig.srcPath.scss + assetsConfig.app + '/**/*.scss', 
		gulp.series('scss'));
	gulp.watch(assetsConfig.srcPath.js + assetsConfig.app + '/**/*.js', 
		gulp.series('uglify'));
});

gulp.task('default', gulp.parallel('scss', 'uglify', 'watch'));

function logError(err) {
	console.log(err.toString());
	this.emit('end');
}
