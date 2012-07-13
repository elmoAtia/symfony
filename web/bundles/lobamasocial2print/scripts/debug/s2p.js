/*! Social2Print Poster App 0.9a | http://lobama.com !*/ 

//
// Social2Print Application JavaScripts 
//
// @author:             emi.petkov[at]gmail.com
// @date:               2012.07.10
// @copyright:          Lobama, Emil Petkov
// @appVersion:         belina
// @fileVersion:        0.1
// 

// jQuery Namespace declaration
jQuery.noConflict();

var s2p = {

    init : function (component, options) {
	//-- Main global vars holder objects
	s2p.vars                                        = {};
        s2p.files                                       = {};
        s2p.texts                                       = {};
        s2p.files.css                                   = {};
        s2p.files.js                                    = {};
        
        //-- Global constants
        s2p.vars.container                              = '#container';
        s2p.vars.version                                = 0.07;
        s2p.vars.baseURI				= 'http://localhost/s2p_dev/app/app_dev.php/services';
	s2p.vars.assetBaseURL                           = '../bundles/lobamasocial2print/';
        s2p.vars.previewPageURL                         = 'http://localhost/s2p_dev/app/app_dev.php/preview';
        s2p.vars.dir                                    = 'debug/';
        s2p.vars.reqExecTime                            = 1000;
        s2p.vars.getProgressURL                         = 'http://localhost/s2p_dev/app/app_dev.php/loading_progress';
        s2p.vars.getCollectURL                          = 'http://localhost/s2p_dev/app/app_dev.php/collect';
        s2p.vars.fadeTime                               = 440;
        s2p.vars.loaderUpdateSteps                      = 100;
        s2p.vars.errorExecTime                          = 3000;



	//-- Extend vars from User options
        jQuery.extend(s2p.vars, options);

	//-- Asset directory
        s2p.vars.scriptDir                              = s2p.vars.assetBaseURL + 'scripts/' + s2p.vars.dir;
        s2p.vars.styleDir                               = s2p.vars.assetBaseURL + 'styles/' + s2p.vars.dir;

	//-- File pathes
	s2p.files.js.mvc 				                = s2p.vars.scriptDir  + 'libs/mvc.js';
	s2p.files.js.jqueryUI				            = s2p.vars.scriptDir  + 'libs/jquery-ui-1.8.16.custom.min.js'	
	//s2p.files.js.helper				                = s2p.vars.scriptDir  + 's2pHelper.js'; 
	s2p.files.js.posterPreview	 		            = s2p.vars.scriptDir  + 's2pPosterPreview.js';
	s2p.files.js.posterPreviewLoader	 	        = s2p.vars.scriptDir  + 's2pPosterPreviewLoader.js'; 
	s2p.files.css.base				                = s2p.vars.styleDir + 'base.css';
	s2p.files.css.posterPreview			            = s2p.vars.styleDir + 's2pPosterPreview.css';
	s2p.files.css.posterPreviewLoader		        = s2p.vars.styleDir + 's2pPosterPreviewLoader.css';
                

        //-- Add Prefix to not execute css files
        yepnope.addPrefix('css', function ( resource ) { resource.forceCSS = true; return resource });
        
        //-- Control caching  
        this.addVersion(s2p.files.js, 'js', s2p.vars.version);
        this.addVersion(s2p.files.css, 'css', s2p.vars.version);
		  
		//-- Main components routing  
		switch(component) {
		   case 'POSTER_PREVIEW':
		  	this.initPosterPreview(options, param1);
			break;
		   case 'POSTER_PREVIEW_LOADER':
		  	this.initPosterPreviewLoader();
			break;
		   case 'HELPER':
		        this.initHelpers(); 
		        break;
		}
    },

    /*
     * Init Poster Preview Loading Page
     * 
     */
    initPosterPreviewLoader : function()
    {
            yepnope([{
                    //load : [s2p.files.js.jqueryUI, s2p.files.js.helper, s2p.files.js.posterPreviewLoader, s2p.files.css.base, s2p.files.css.posterPreviewLoader],
                    load : [s2p.files.js.jqueryUI, s2p.files.js.posterPreviewLoader, s2p.files.css.base, s2p.files.css.posterPreviewLoader],
		    complete : function() {
                            s2p.showContainer();
                            PosterPreviewLoader.init();
                    }
            }]);
    },

    /*
     * Fades main Container in
     *
     *  @params: executes a callback function
     */
    showContainer : function(callback) {
            jQuery(s2p.vars.container).fadeIn(s2p.vars.fadeTime, callback);
    },
    
    /*
     * Fades main Container out
     *
     * @params: executes a callback function
     */
    hideContainer : function(callback) {
            jQuery(s2p.vars.container).fadeIn(s2p.vars.fadeTime, callback);
    },
        
    /*
     * Applies a version string to each prop in the given object
     * 
     * @param: Object      -> 'obj' Object that contains all file pathes
     * @paran: String      -> 'type' String contains the filetype
     * @since:             1.18
     */
    addVersion : function(obj, type, version) {
        for (var prop in obj) {
            if (obj.hasOwnProperty(prop)) {
               obj[prop] = type + '!' + obj[prop] + '?version='+ version; 
            }
        }
    },

    /*
     * Init Poster Preview Page
     * @params: JSON Poster data 
     * 
     */
    initPosterPreview : function(options, data)
    {   
            yepnope([{
                    load : [s2p.files.js.mvc, s2p.files.js.posterPreview, s2p.files.css.base, s2p.files.css.posterPreview],
                    complete : function() {
                            s2p.showContainer();
                            new PosterPreview(options, data);
                    }
            }]);
    },

}
