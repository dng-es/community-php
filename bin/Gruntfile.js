 module.exports = function(grunt) {
 	
var processorsArray = [
  // snipped for brevity
  require('autoprefixer')({ browsers: ['last 2 versions', 'ie 6-8', 'Firefox > 20']  })
];

   // Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		public_html : "../httpdocs/",
		
		// CONFIG ===================================/
		watch: {
			sass: {
				files: ['<%= public_html %>css/*.{scss,sass}', '<%= public_html %>css/libs/*/*.{scss,sass}', '<%= public_html %>app/modules/*/resources/css/*.{scss,sass}', '<%= public_html %>themes/*/css/*.{scss,sass}'],
				tasks: ['sass:prod'],
				options: {
					livereload: true,
				}
			},
			js: {
				files: ['<%= public_html %>js/libs/*.js'],
				tasks: ['uglify:prod']
			}
			/*, images:{
				files: ['<%= public_html %>images/*.png', '<%= public_html %>images/*.gif','<%= public_html %>images/*.{jpg,jpeg}'],
				tasks: ['imagemin'],
                options: {
                    spawn: false
                }		
			}*/
		},

		sass: {
			dev: {
				options: {
					compass: true,
					style: 'compressed'
				},
				files: [
					{
						expand: true,
						src: '<%= public_html %>/css/*.scss',
						dest: './',
        				ext: '.css'
					},
					{
						expand: true,
						src: ['<%= public_html %>/app/modules/*/resources/css/*.scss'],
						dest: './',
        				ext: '.css'
					},
					{
						expand: true,
						src: ['<%= public_html %>/themes/*/css/*.scss'],
						dest: './',
        				ext: '.css'
					}
				]
			},
			prod: {
				options: {
					compass: true,
					style: 'compressed'
				},
				files: [
					{
						expand: true,
						src: '<%= public_html %>/css/*.scss',
						dest: './',
        				ext: '.css'
					},
					{
						expand: true,
						src: ['<%= public_html %>/app/modules/*/resources/css/*.scss'],
						dest: './',
        				ext: '.css'
					},
					{
						expand: true,
						src: ['<%= public_html %>/themes/*/css/*.scss'],
						dest: './',
        				ext: '.css'
					}
				]
			}
		},		

		uglify: {
		   dev: {
		       files: {
		           '<%= public_html %>js/main.min.js': [
		           '<%= public_html %>js/libs/jquery-*.js',
		           '<%= public_html %>js/libs/customscrollbar/jquery.mCustomScrollbar.min.js',
		           '<%= public_html %>js/libs/sweetalert/sweet-alert.js', 
		           '<%= public_html %>js/libs/functions.js', 
		           '<%= public_html %>css/libs/bootstrap*/assets/javascripts/bootstrap.js', 
		           '<%= public_html %>js/bootstrap-dropdown.js', 
		           '<%= public_html %>js/libs/main.js'
		           ]
		       },
		       options: {
		            preserveComments: true,
		            compress: false
		       }
		   },

		   prod: {
		       files: {
		           '<%= public_html %>js/main.min.js': [
		           '<%= public_html %>js/libs/jquery-*.js',
		           '<%= public_html %>js/libs/sweetalert/sweet-alert.js', 
		           '<%= public_html %>js/libs/functions.js', 
		           '<%= public_html %>css/libs/bootstrap*/assets/javascripts/bootstrap.js', 
		           '<%= public_html %>js/bootstrap-dropdown.js', 
		           '<%= public_html %>js/libs/main.js'
		           ]
		       },
		       options: {
		            preserveComments: false
		       }
		   },
		},
		styles: {
			options: {
				processors: processorsArray
			},
			dist: {
				src: '<%= public_html %>css/test.css',
				dest: '<%= public_html %>css/postcss/test.css'
			}
		}

	});
 
	// DEPENDENT PLUGINS =========================/

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-postcss');

	// TASKS =====================================/

	grunt.registerTask('default', []);
	grunt.registerTask('prod', ['sass:prod', 'uglify:prod']);
	grunt.registerTask('dev', ['sass:dev', 'uglify:dev']);
	grunt.registerTask('styles', ['styles']);
};