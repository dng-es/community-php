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

	});
 
	// DEPENDENT PLUGINS =========================/

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	// TASKS =====================================/

	grunt.registerTask('default', []);
	grunt.registerTask('prod', ['compass:prod', 'uglify:prod']);
	grunt.registerTask('dev', ['compass:dev', 'uglify:dev']);
};