//Gruntfile

module.exports = function(grunt) {
    //Initialize config object

    grunt.initConfig({
        less: {
            development: {
                options: {
                    compress: false
                },
                files: {
                    //compiling src files into public assets
                    "./public/css/frontend.css":"./resources/css/frontend.less",
                    "./public/admin/css/backend.css":"./resources/css/backend.less"
                }
            }
        },
        watch: {
            less: {
                files: ['./resources/css/*.less'], //watched files
                tasks: ['less']
            }
        }
    });

    //plugins
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');
    //task definitions
    grunt.registerInitTask('default', ['watch']);
};

