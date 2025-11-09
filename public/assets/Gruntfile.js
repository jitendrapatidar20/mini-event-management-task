module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: {
			dist: {
				files: {
					'css/main.css' : 'scss/style.scss',
					// 'css/responsive.css' : 'sass/responsive.scss'
				}
			},
		},
		watch: {
			css: {
				files: 'scss/**/*.scss',
				tasks: ['sass','postcss'],
				options: {
			      livereload: true,
			    },
			},
			options: {
		      livereload: true,
		    },
		},
		postcss: {
		    options: {
		      map: true, // inline sourcemaps
		      // or
		      map: {
		          inline: true, // save all sourcemaps as separate files...
		          annotation: 'css/' // ...to the specified directory
		      },
		      processors: [
		        require('pixrem')(), // add fallbacks for rem units
		        require('autoprefixer')({browsers: 'last 2 versions'}), // add vendor prefixes
		        require('cssnano')() // minify the result
		      ]
		    },
		    dist: {
		      src: 'css/main.css',
			  dest: 'css/style-html.css'
		    }
	  }

	});
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-postcss');

	grunt.registerTask('default',['watch']);
}
