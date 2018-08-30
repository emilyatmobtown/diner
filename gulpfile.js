/**
 * Gulpfile.
 *
 * Gulp for Diner WordPress theme.
 *
 * Implements:
 *      1. Live reloads browser with BrowserSync.
 *      2. CSS: Sass to CSS conversion, error catching, Autoprefixing,
 *         CSS minification, and Merge Media Queries.
 *      3. JS: Reorders, concatenates & uglifies Vendor and Custom JS files.
 *      4. Images: Minifies PNG, JPEG, GIF and SVG images.
 *      5. Watches files for changes in CSS or JS.
 *      6. Collects theme files and builds installable zip.
 *
 * @author Emily Leffler Schulman
 * @version 1.0.3
 */
 
 'use strict';
 
var project = 'diner';

const

  // Source and build folders
  dir = {
    src         : 'src/',
    build       : './',
    buildTheme	: './themefiles/'
  },

  // Gulp and plugins
  gulp          = require( 'gulp' ),
  gutil         = require( 'gulp-util' ), 			// Stream utilities
  newer         = require( 'gulp-newer' ), 			// Only pass newer source files
  imagemin      = require( 'gulp-imagemin' ), 		// Minifier
  sass          = require( 'gulp-sass' ), 			// Sass compiler
  postcss       = require( 'gulp-postcss' ),		// CSS processor
  deporder      = require( 'gulp-deporder' ), 		// Re-order JS/CSS files in the stream
  concat        = require( 'gulp-concat' ),			// Concatenate files
  stripdebug    = require( 'gulp-strip-debug' ),	// Strip debugging
  uglify        = require( 'gulp-uglify' ),			// Minify JS
  rename	= require( 'gulp-rename' ), 		// Renames files
  zip           = require( 'gulp-zip' ),			// Zips files
  runSequence   = require( 'gulp-run-sequence' ),	// Sequences task order
  lineec       	= require( 'gulp-line-ending-corrector' ); // Consistent Line Endings

// Buld files for theme zip
var buildInclude = [
				// include common file types
				'**/*.php',
				'**/*.html',
				'**/*.css',
				'**/*.js',
				'**/*.svg',
				'**/*.ttf',
				'**/*.otf',
				'**/*.eot',
				'**/*.woff',
				'**/*.woff2',
				'**/*.pot',
				'**/*.txt',
			
				// include specific files and folders
				'screenshot.png',
				'LICENSE',				
			
				// exclude files and folders
				'!{node_modules,node_modules/**/*}',
				'!{src,src/**/*}',
				'!gulpfile.js', 
			    '!package.json', 
			    '!package-lock.json',
			    '!themefiles'
];

// Browsersync
var browsersync = false;

// Image settings
const images = {
  src         : dir.src + 'img/**/*',
  build       : dir.build + 'img/'
};

// Image processing
gulp.task( 'images', () => {
  return gulp.src( images.src )
    .pipe(  newer( images.build ) )
    .pipe(  imagemin() )
    .pipe(  gulp.dest( images.build ) );
});

// CSS settings
var css = {
  src         : dir.src + 'scss/style.scss',
  watch       : dir.src + 'scss/**/*',
  build       : dir.build,
  sassOpts: {
    outputStyle     : 'nested',
    imagePath       : images.build,
    precision       : 3,
    errLogToConsole : true
  },
  processors: [
    require( 'postcss-assets' )({
      loadPaths: ['img/'],
      basePath: dir.build + 'img/',
      baseUrl: '/wp_sandbox/wp-content/themes/diner/img/'
    }),
    require( 'autoprefixer' )({
      browsers: ['last 2 versions', '> 2%']
    }),
    require( 'css-mqpacker' ),
    require( 'cssnano' )
  ]
};

// CSS processing
gulp.task( 'css', ['images'], () => {
  return gulp.src(css.src)
    .pipe( sass( css.sassOpts ) )
    .pipe( postcss( css.processors ) )
   	.pipe( lineec() )
    .pipe( gulp.dest( css.build ) )
    .pipe( browsersync ? browsersync.reload( { stream: true } ) : gutil.noop() );
});

// JavaScript settings
const js = {
  src         : dir.src + 'js/**/*',
  build       : dir.build + 'js/',
  filename    : 'scripts'
};

// JavaScript processing
gulp.task( 'js', () => {

  return gulp.src( js.src )
    .pipe( deporder() )
    .pipe( concat( js.filename ) )
    .pipe( stripdebug() )
    .pipe( rename( {
      basename	: js.filename,
      suffix	: '.min',
      extname	: '.js'
    }))
    .pipe( uglify() )
   	.pipe( lineec() )
    .pipe( gulp.dest( js.build ) )
    .pipe( browsersync ? browsersync.reload( { stream: true } ) : gutil.noop() );

});

// Run all tasks
gulp.task( 'build', ['css', 'js'] );

// Browsersync options
const syncOpts = {
  proxy       : 'localhost:8888/wp_sandbox',
  files       : dir.build + '**/*',
  open        : true,
  notify      : true,
  ghostMode   : false,
  injectChanges: true,
  browser 	  : 'google chrome',
  port		  : 8888
};

// Browsersync
gulp.task( 'browsersync', () => {
  if ( browsersync === false ) {
    browsersync = require( 'browser-sync' ).create();
    browsersync.init( syncOpts );
  }
});

// Watch for file changes
gulp.task( 'watch', ['browsersync'], () => {

  // image changes
  gulp.watch( images.src, ['images'] );

    // CSS changes
  gulp.watch( css.watch, ['css'] );

  // JavaScript main changes
  gulp.watch( js.src, ['js']) ;

});

// Default task
gulp.task( 'default', ['build', 'watch'] );

// Moves essential theme files for production-ready sites
gulp.task( 'buildFiles', () => {
	return gulp.src( buildInclude )
		.pipe( gulp.dest( dir.buildTheme ) );
});

// Zips for distribution
gulp.task( 'buildZip', () => {
	return 	gulp.src( dir.buildTheme+'/**/' )
 		.pipe( zip( project+'.zip') )
 		.pipe( gulp.dest( './' ) );
 });
 
// Package distributable theme
gulp.task( 'buildFinal', function( cb ) {
	runSequence( 'build', 'buildFiles', 'buildZip', cb );
});
