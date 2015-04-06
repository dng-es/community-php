 module.exports = function(grunt) {
 	

   // Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		public_html : "../httpdocs/",
		
		// CONFIG ===================================/
		watch: {
			compass: {
				files: ['<%= public_html %>css/*.{scss,sass}', '<%= public_html %>css/libs/*/*.{scss,sass}'],
				tasks: ['compass:prod'],
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

		compass: {
		   dev: {
		       options: {
		       	   config: '<%= public_html %>css/config.rb',         
		           sassDir: ['<%= public_html %>css'],
		           cssDir: ['<%= public_html %>css'],
		           environment: 'development'
		       }
		   },

		   prod: {
		       options: {              
		           config: '<%= public_html %>css/config.rb', 
		           sassDir: ['<%= public_html %>css'],
		           cssDir: ['<%= public_html %>css'],
		           environment: 'production'
		      }
	      },

		},

		uglify: {
		   dev: {
		       files: {
		           '<%= public_html %>js/main.min.js': [
		           '<%= public_html %>js/libs/jquery-*.js',
		           '<%= public_html %>js/libs/jqueryui-*.min.js',
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
		           '<%= public_html %>js/libs/jqueryui-*.min.js',
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

		imagemin: {                          // Task

			jpg: {
			      options: {
			        progressive: true
			      },
			      files: [
			        {
			          // Set to true to enable the following options…
			          expand: true,
			          // cwd is 'current working directory'
			          cwd: '../httpdocs/images/',
			          src: ['*.jpg'],
			          // Could also match cwd. i.e. project-directory/img/
			          dest: '../httpdocs/images/build/',
			          ext: '.jpg'
			        }
			      ]
			    }
		  }

	});
 
	// DEPENDENT PLUGINS =========================/

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-imagemin');

	// TASKS =====================================/

	grunt.registerTask('default', []);
	grunt.registerTask('prod', ['compass:prod', 'uglify:prod', 'images']);
	grunt.registerTask('dev', ['compass:dev', 'uglify:dev', 'images']);
};