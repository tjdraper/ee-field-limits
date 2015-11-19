module.exports = function(grunt) {
	var projectFile = grunt.file.readJSON('project.json'),
		addOnDir = projectFile.addOnDir,
		cssDir = projectFile.cssDir,
		jsDir = projectFile.jsDir,
		cssFile = projectFile.cssFile,
		jsFile = projectFile.jsFile,
		conf = {
			addOnDir: addOnDir,
			cssDir: cssDir,
			jsDir: jsDir,
			cssFile: cssFile,
			jsFile: jsFile,
			bsFiles: {
				src: [
					addOnDir + '/' + cssDir + '/' + cssFile,
					addOnDir + '/' + jsDir + '/' + jsFile
				]
			},
			bsOptions: {
				watchTask: true,
				proxy: projectFile.proxy,
				ghostMode: {
					clicks: false,
					forms: false,
					scroll: false,
					links: false
				},
				open: 'external',
				notify: false
			},
			lessCompress: projectFile.lessCompress,
			lessFiles: {},
			jsFiles: {}
		};

	// Configure proxy
	if (projectFile.proxy === false) {
		conf.bsOptions.open = false;
	}

	// Configure less files
	conf.lessFiles[addOnDir + '/' + cssDir + '/' + cssFile] = [
		'source/css/build/*.less',
		'source/css/build/*.css',
		'source/css/fab.less'
	];

	if (projectFile.lessBuild.length) {
		projectFile.lessBuild.forEach(function(i) {
			conf.lessFiles[addOnDir + '/' + cssDir + '/' + cssFile].push(
				'source/css/' + i
			);
		});
	}

	if (Object.keys(projectFile.lessFiles).length) {
		for (var key in projectFile.lessFiles) {
			conf.lessFiles[addOnDir + '/' + cssDir + '/' + key] =
				'source/' + projectFile.lessFiles[key];
		}
	}

	conf.jsFiles[addOnDir + '/' + jsDir + '/' + jsFile] = [];

	if (projectFile.jsBuildBefore.length) {
		projectFile.jsBuildBefore.forEach(function(i) {
			conf.jsFiles[addOnDir + '/' + jsDir + '/' + jsFile].push(
				'source/js/' + i
			);
		});
	}

	// Configure JS files
	conf.jsFiles[addOnDir + '/' + jsDir + '/' + jsFile].push(
		'source/js/fab.js',
		'source/js/base/*.js',
		'source/js/controller.js',
		'source/js/build/*.js'
	);

	if (projectFile.jsBuild.length) {
		projectFile.jsBuild.forEach(function(i) {
			conf.jsFiles[addOnDir + '/' + jsDir + '/' + jsFile].push(
				'source/js/' + i
			);
		});
	}

	conf.jsFiles[addOnDir + '/' + jsDir + '/' + jsFile].push(
		'source/js/ready.js'
	);

	if (Object.keys(projectFile.jsFiles).length) {
		for (var key in projectFile.jsFiles) {
			conf.jsFiles[addOnDir + '/' + jsDir + '/' + key] =
				'source/' + projectFile.jsFiles[key];
		}
	}

	grunt.initConfig({
		conf: conf,
		projectFile: projectFile,
		browserSync: {
			bsFiles: conf.bsFiles,
			options: conf.bsOptions
		},
		notify: {
			less: {
				options: {
					title: 'CSS',
					message: 'CSS compiled successfully'
				}
			},
			uglify: {
				options: {
					title: 'Javascript',
					message: 'Javascript compiled successfully'
				}
			}
		},
		less: {
			development: {
				options: {
					compress: conf.lessCompress,
					yuicompress: conf.lessCompress,
					optimization: 2
				},
				files: conf.lessFiles
			}
		},
		uglify: {
			build: {
				options: {
					sourceMap: true
				},
				files: conf.jsFiles
			}
		},
		jshint: {
			files: [
				'source/js/*.js',
				'source/js/base/*.js',
				'source/js/build/*.js'
			],
			options: {
				jshintrc: true
			}
		},
		jscs: {
			src: [
				'source/js/*.js',
				'source/js/base/*.js',
				'source/js/build/*.js'
			],
			options: {
				config: '.jscs.json'
			}
		},
		watch: {
			styles: {
				files: [
					'source/css/*.less',
					'source/css/*/*.less',
					'source/css/*/*.css'
				],
				tasks: [
					'less',
					'notify:less'
				],
				options: {
					spawn: false
				}
			},
			javascript: {
				files: [
					'source/js/*.js',
					'source/js/*/*.js'
				],
				tasks: [
					'uglify',
					'notify:uglify'
				],
				options: {
					spawn: false
				}
			},
			jshint: {
				files: [
					'<%= jshint.files %>'
				],
				tasks: [
					'jshint'
				],
				options: {
					spawn: false
				}
			},
			jscs: {
				files: [
					'<%= jscs.src %>'
				],
				tasks: [
					'jscs'
				],
				options: {
					spawn: false
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-jscs');
	grunt.loadNpmTasks('grunt-notify');
	grunt.loadNpmTasks('grunt-browser-sync');

	grunt.registerTask('default', [
		'less',
		'uglify',
		'notify:less',
		'notify:uglify',
		'browserSync',
		'watch'
	]);

	grunt.registerTask('compile', [
		'less',
		'uglify'
	]);
};