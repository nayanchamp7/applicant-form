/**
 * Gulp Config
 * @version 1.0.0
 * @author Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @package Applicant_Form
 * @copyright 2020 Nayan
 */
const app = require( './package.json' );
const gulp = require( 'gulp' );
const eslint = require( 'gulp-eslint' );
const babel = require( 'gulp-babel' );
const prettify = require( 'gulp-js-prettify' );
const uglify = require( 'gulp-uglify' );
const rename = require( 'gulp-rename' );
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require( 'gulp-sourcemaps' );
const minifyCSS = require( 'gulp-clean-css' );
const autoprefixer = require( 'gulp-autoprefixer' );
const wpPot = require( 'gulp-wp-pot' );
const zip = require('gulp-zip');
const notify = require( 'gulp-notify' );
const checktextdomain = require('gulp-checktextdomain');
const wptextdomain = require( 'wp-textdomain' );

const config = {
	babel: {
		presets: ['@babel/preset-env']
	},
	prettify: {
		"indent_with_tabs": true
	},
	js: {
		src: ['assets/admin/js/*.js', '!assets/admin/js/*.min.js'],
		dist: 'assets/admin/js/',
	},
	scss: {
		src: 'assets/admin/css/*.scss',
		dist: 'assets/admin/css/',
	},
	public_scss: {
		src: 'assets/public/css/*.scss',
		dist: 'assets/public/css/',
	},
	public_js: {
		src: ['assets/public/js/*.js', '!assets/public/js/*.min.js'],
		dist: 'assets/public/js/',
	},
	autoprefixer: {
		options: {
			cascade: false,
		},
	},
	wp_textdomain: {
		src: [
			'**/*',
			'!.git/**',
			'!node_modules/**',
			'!.browserslistrc',
			'!.eslintrc',
			'!.gitignore',
			'!gulpfile.js',
			'!package.json',
			'!package-lock.json',
			'!phpcs.xml'
		],
	},
};

// Tasks
gulp.task(
	'compile:js',
	() => {
		return gulp.src( config.js.src )
			.pipe( sourcemaps.init( { largeFile: true } ) )
			.pipe( eslint() )
			.pipe( eslint.format() )
			.pipe( babel( config.babel ) )
			.on( 'error', notify.onError( {title: "Error", message: "Error: <%= error.message %>"} ) ) // phpcs:ignore WordPressVIPMinimum.Security.Underscorejs.OutputNotation
			.pipe( prettify( config.prettify ) )
			// .pipe( gulp.dest( config.js.dist ) )
			.pipe( uglify() )
			.pipe( rename( { suffix: '.min' } ) )
			.pipe( sourcemaps.write( '/.' ) )
			.pipe( gulp.dest( config.js.dist ) )
			.pipe( notify( {message: 'TASK: compile:js Completed! 💯', onLast: true} ) );
	}
);
gulp.task(
	'compile:scss',
	() => {
		return gulp.src( config.scss.src )
			.pipe( sass().on( 'error', sass.logError ) )
			.on( 'error', notify.onError( {title: "Error", message: "Error: <%= error.message %>"} ) ) // phpcs:ignore WordPressVIPMinimum.Security.Underscorejs.OutputNotation
			.pipe( autoprefixer( config.autoprefixer.options ) )
			.pipe( gulp.dest( config.scss.dist ) )
			.pipe( minifyCSS() )
			.pipe( rename( { suffix: '.min'} ) )
			.pipe( gulp.dest( config.scss.dist ) )
			.pipe( notify( {message: 'TASK: compile:scss Completed! 💯', onLast: true} ) );
	}
);
gulp.task(
	'compile:public:scss',
	() => {
		return gulp.src( config.public_scss.src )
			.pipe( sass().on( 'error', sass.logError ) )
			.on( 'error', notify.onError( {title: "Error", message: "Error: <%= error.message %>"} ) ) // phpcs:ignore WordPressVIPMinimum.Security.Underscorejs.OutputNotation
			.pipe( autoprefixer( config.autoprefixer.options ) )
			.pipe( gulp.dest( config.public_scss.dist ) )
			.pipe( minifyCSS() )
			.pipe( rename( { suffix: '.min'} ) )
			.pipe( gulp.dest( config.public_scss.dist ) )
			.pipe( notify( {message: 'TASK: compile:scss Completed! 💯', onLast: true} ) );
	}
);
gulp.task(
	'compile:public:js',
	() => {
		return gulp.src( config.public_js.src )
			.pipe( sourcemaps.init( { largeFile: true } ) )
			.pipe( eslint() )
			.pipe( eslint.format() )
			.pipe( babel( config.babel ) )
			.on( 'error', notify.onError( {title: "Error", message: "Error: <%= error.message %>"} ) ) // phpcs:ignore WordPressVIPMinimum.Security.Underscorejs.OutputNotation
			.pipe( prettify( config.prettify ) )
			// .pipe( gulp.dest( config.js.dist ) )
			.pipe( uglify() )
			.pipe( rename( { suffix: '.min' } ) )
			.pipe( sourcemaps.write( '/.' ) )
			.pipe( gulp.dest( config.public_js.dist ) )
			.pipe( notify( {message: 'TASK: compile:js Completed! 💯', onLast: true} ) );
	}
);
gulp.task(
	'makePot',
	() => {
		return gulp.src( config.pot.src )
			.pipe( wpPot( config.pot.options ) )
			.on( 'error', notify.onError( {title: "Error", message: "Error: <%= error.message %>"} ) ) // phpcs:ignore WordPressVIPMinimum.Security.Underscorejs.OutputNotation
			.pipe( gulp.dest( config.pot.dist ) )
			.pipe( notify( {message: 'TASK: makePot Completed! 💯', onLast: true} ) );
	}
);
gulp.task(
	'makeZip',
	() => {
		return gulp.src( config.zip.src )
			.pipe( zip(config.zip.file_name.replace('.zip','') + '.zip'), config.zip.options )
			.pipe( gulp.dest( config.zip.dist ) )
			.pipe( notify( {message: 'Zipping Completed! 💯', onLast: true} ) );
	}
);
gulp.task( 'build', gulp.series( 'compile:js', 'compile:scss', 'compile:public:scss' ) );
gulp.task(
	'watch',
	function () {
		gulp.watch( config.js.src, gulp.series( 'compile:js' ) );
		gulp.watch( config.scss.src, gulp.series( 'compile:scss' ) );
		gulp.watch( config.public_scss.src, gulp.series( 'compile:public:scss' ) );
		gulp.watch( config.public_js.src, gulp.series( 'compile:public:js' ) );
	}
);

gulp.task('checktextdomain', function() {
	return gulp
		.src('**/*.php')
		.pipe(checktextdomain({
			text_domain: 'applicant-form', //Specify allowed domain(s)
			keywords: [ //List keyword specifications
				'__:1,2d',
				'_e:1,2d',
				'_x:1,2c,3d',
				'esc_html__:1,2d',
				'esc_html_e:1,2d',
				'esc_html_x:1,2c,3d',
				'esc_attr__:1,2d',
				'esc_attr_e:1,2d',
				'esc_attr_x:1,2c,3d',
				'_ex:1,2c,3d',
				'_n:1,2,4d',
				'_nx:1,2,4c,5d',
				'_n_noop:1,2,3d',
				'_nx_noop:1,2,3c,4d'
			],
		}));
});

gulp.task('textdomain', function() {
	return gulp
		.src( config.wp_textdomain.src )
		.pipe( wptextdomain( '**/*.php', {
			domain: 'applicant-form', //Specify allowed domain(s)
			fix: true,
			keywords: [ //List keyword specifications
				'__:1,2d',
				'_e:1,2d',
				'_x:1,2c,3d',
				'esc_html__:1,2d',
				'esc_html_e:1,2d',
				'esc_html_x:1,2c,3d',
				'esc_attr__:1,2d',
				'esc_attr_e:1,2d',
				'esc_attr_x:1,2c,3d',
				'_ex:1,2c,3d',
				'_n:1,2,4d',
				'_nx:1,2,4c,5d',
				'_n_noop:1,2,3d',
				'_nx_noop:1,2,3c,4d'
			],
		}));
});

