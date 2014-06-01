module.exports = function( grunt ) {
	'use strict';

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		jshint: {
			all: [
				'angular-wp-api.js'
			],
			grunt: {
				src: [ 'Gruntfile.js' ]
			},
			options: {
				jshintrc: '.jshintrc'
			}
		},
		uglify: {
			js: {
				options: {
					sourceMap: true
				},
				files: {
					'angular-wp-api.min.js': [ 'angular-wp-api.js' ]
				}
			}
		},
		watch:  {
			scripts: {
				files: [ 'angular-wp-api.js'],
				tasks: ['jshint', 'uglify'],
				force: true,
				options: {
					debounceDelay: 500
				}
			}
		}
	} );

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	
	grunt.registerTask( 'default', ['jshint', 'uglify'] );

	grunt.util.linefeed = '\n';
};