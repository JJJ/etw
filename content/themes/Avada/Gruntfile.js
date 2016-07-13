var shell = require('shelljs');

module.exports = function(grunt) {
	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		po2mo: {
			options: {
			},
			files: {
				src: 'languages/*.po',
				expand: true,
			},
		},
		less: {
			development: {
				files: {
					'style.css': 'assets/less/style.less',
					'shortcodes.css': 'assets/less/shortcodes.less',
					'ilightbox.css': 'assets/less/plugins/iLightbox/iLightbox.less',
					'animations.css': 'assets/less/theme/animations.less',
					'assets/css/rtl.css': 'assets/less/theme/rtl.less',
					'assets/css/woocommerce.css': 'assets/less/theme/woocommerce.less'
				}
			}
		},
		concat: {
			options: {
				separator: ';'
			},
			development: {
				src: [
					'assets/js/bootstrap.js',
					'assets/js/cssua.js',
					'assets/js/easyPieChart.js',
					'assets/js/excanvas.js',
					'assets/js/Froogaloop.js',
					'assets/js/imagesLoaded.js',
					'assets/js/isotope.js',
					'assets/js/jquery.appear.js',
					'assets/js/jquery.touchSwipe.js',
					'assets/js/jquery.carouFredSel.js',
					'assets/js/jquery.countTo.js',
					'assets/js/jquery.cycle.js',
					'assets/js/jquery.easing.js',
					'assets/js/jquery.elasticslider.js',
					'assets/js/jquery.fitvids.js',
                    'assets/js/jquery.nicescroll.js',
					'assets/js/jquery.flexslider.js',
					'assets/js/jquery.fusion_maps.js',
					'assets/js/jquery.hoverflow.js',
					'assets/js/jquery.hoverIntent.js',
					'assets/js/jquery.infinitescroll.js',
					'assets/js/jquery.placeholder.js',
					'assets/js/jquery.toTop.js',
					'assets/js/jquery.waypoints.js',
					'assets/js/modernizr.js',
					'assets/js/jquery.requestAnimationFrame.js',
					'assets/js/jquery.mousewheel.js',
					'assets/js/ilightbox.js',
					'assets/js/avada-lightbox.js',
                    'assets/js/avada-select.js',
                    'assets/js/avada-nicescroll.js',
                    'assets/js/avada-bbpress.js',
                    'assets/js/avada-woocommerce.js',
                    'assets/js/avada-parallax.js',
                    'assets/js/avada-video-bg.js',
                    'assets/js/avada-header.js',
					'assets/js/theme.js'

				],
				dest: 'assets/js/main.js'
			}
		},
		uglify: {
			development: {
				options: {
					mangle: true,
					compress: {
						sequences: true,
						dead_code: true,
						conditionals: true,
						booleans: true,
						unused: true,
						if_return: true,
						join_vars: true,
						drop_console: true
					}
				},
				files: {
					'assets/js/main.min.js': ['assets/js/main.js']
				}
			}
		},
		watch: {
			css: {
				files: ['**/*.less'],
				tasks: ['less:development']
			}
		},
		webfont: {
			icons: {
				src: 'fusion-icon/svg/*.svg',
				dest: 'assets/fonts/fusion-icon',
				destCss: 'assets/less/',
				engine: 'node',
				options: {
					font: 'fusion-icon',
					//classPrefix: "fusion-icon-",
					//baseClass: "fusion-icon-",
					syntax: "bootstrap",
					types: "eot,woff,ttf,svg",
					'relativeFontPath' : 'assets/fonts/fusion-icon/',
					templateOptions: {
						baseClass: '',
						classPrefix: 'fusion-icon-',
						//mixinPrefix: 'fusion-icon-'
					},
					template: 'fusion-icon/template/template.css',
					stylesheet: "less",
					destHtml: "assets/fonts/fusion-icon",
					htmlDemoTemplate: "fusion-icon/template/template.html",
					//ie7: true,
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-webfont');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-po2mo');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask('watchCSS', ['watch:css']);
	grunt.registerTask('default', ['less:development', 'concat:development', 'uglify:development']);

	grunt.registerTask('langUpdate', 'Update languages', function() {
		shell.exec('tx pull -r avada.avadapo -a --minimum-perc=10');
		shell.exec('tx pull -r avada.fusion-corepo -a --minimum-perc=10');
		shell.exec('grunt po2mo');
	});
};