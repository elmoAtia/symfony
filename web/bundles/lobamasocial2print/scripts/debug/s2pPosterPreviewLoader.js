/* 

 * Social2Print PosterPreviewLoader JavaScripts 

 *

 * @name:               s2pPosterPreviewLoader.js

 * @author:             emi.petkov[at]gmail.com

 * @date:               2012.02.03

 * @copyright:          Lobama, Emil Petkov

 * @appVersion:         belina

 * @fileVersion:        0.07

 * 

 * 

 * 

 * @TODO: Ajax-Request for start collect

 *        After than > Request to update the server loading progress

 *        

 */



var PosterPreviewLoader = {



     init : function() {

             this.startCollect();

             this.preloadPreview();

     }, 



     preloadPreview : function() { 

           this.bar =  jQuery( ".progress-bar" );

           this.barValue =  jQuery( ".progress-value" );

           this.loadingProgress = 100;

           this.bar.progressbar({ value: this.loadingProgress, creat: this.loadingGetProgress() }); 

           //this.bar.bind( 'progressbarcomplete', this.loadingComplete ); 

     },

     loadingGetProgress : function() {

            var _this = PosterPreviewLoader;

            

            setTimeout(function() {  			

                // Ajax call to get current Progress

                _this.getServerResponse(_this.getLoadingProgressComplete);

            }, s2p.vars.loaderUpdateSteps);

     },

     

     getLoadingProgressComplete : function(v)

     {

          var _this = PosterPreviewLoader;

          _this.loadingProgress = parseInt(v);

          

          // Quickfix

          _this.loadingProgress = 100;

          // /Quickfix

          

          _this.loadingSetProgress(_this.loadingProgress);           

          // And again, every x ms

          _this.loadingGetProgress()

     }, 

      

     loadingSetProgress : function(progressValue) 

     {

            this.bar.progressbar({ value: progressValue });

            this.barValue.text(progressValue + '%') 

     },

     

     loadingComplete : function(previewURL) 

     {

          console.log(previewURL);

          this.bar.progressbar({disabled : true});

          //jQuery(s2p.container).fadeOut(s2p.vars.fadeTime, function() {

            document.location.href = previewURL; 

          //});

     },

     

     getServerResponse : function(callback) 

     {

       jQuery.ajax({

          url : s2p.vars.getProgressURL,

          cache : false,

          dataType : 'json',

          success : function(data) { 

                callback( typeof data ? data.progress : null ) 

            }

       });

     },

     

     /*

      * Starts collecting items

      * 

      */

     startCollect : function() {

        jQuery.ajax({

          url : s2p.vars.getCollectURL,

          cache : false,

          dataType : 'json',

          success : function(data) { 
		console.log('hi');

                PosterPreviewLoader.loadingComplete(data.redirectURL);

            }

        }); 

     }

     

}
