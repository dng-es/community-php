

 module.exports = function(grunt) {
 
   // Project configuration.
   grunt.initConfig({
     pkg: grunt.file.readJSON('package.json'),
   // CONFIG ===================================/
	watch: {
		compass: {
			files: ['../css/*.{scss,sass}'],
			tasks: ['compass:dev']
		},
		js: {
			files: ['../js/libs/*.js'],
			tasks: ['uglify:dev']
		}
	},

	compass: {
	   dev: {
	       options: {              
	           sassDir: ['../css'],
	           cssDir: ['../css'],
	           environment: 'development'
	       }
	   },

	   prod: {
	       options: {              
	           sassDir: ['../css'],
	           cssDir: ['../css'],
	           environment: 'production'
	      }
      },

	},

	uglify: {
	   dev: {
	       files: {
	           '../js/main.min.js': [
	           '../js/libs/jquery-*.js',
	           '../js/libs/functions.js', 
	           '../css/libs/bootstrap*/assets/javascripts/bootstrap.js', 
	           '../js/bootstrap-dropdown.js', 
	           '../js/libs/main.js'
	           ]
	       }
	   },

	   prod: {
	       files: {
	           '../js/main.min.js': [
	           '../js/libs/jquery-*.js',
	           '../js/libs/functions.js', 
	           '../css/libs/bootstrap*/assets/javascripts/bootstrap.js', 
	           '../js/bootstrap-dropdown.js', 
	           '../js/libs/main.js'
	           ]
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
};