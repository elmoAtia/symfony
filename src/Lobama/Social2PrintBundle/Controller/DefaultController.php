<?php

namespace Lobama\Social2PrintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Yaml\Yaml;    // To parse the poster configuration files
use Symfony\Components\CssSelector\Parser;  // To parse the payment XML
use Facebook;
use Lobama\Social2PrintBundle\Entity\User;
use Lobama\Social2PrintBundle\Entity\Album;
use Lobama\Social2PrintBundle\Entity\Photo;
use Lobama\Social2PrintBundle\Entity\FacebookLike;
use Lobama\Social2PrintBundle\Entity\FacebookComment;
use Lobama\Social2PrintBundle\Entity\Score;
use Lobama\Social2PrintBundle\Entity\ScoreType;
use Lobama\Social2PrintBundle\Entity\Poster;
use Lobama\Social2PrintBundle\Entity\PosterPhoto;


class DefaultController extends Controller
{
    

    /*
        ___   ____________________  _   _______
       /   | / ____/_  __/  _/ __ \/ | / / ___/
      / /| |/ /     / /  / // / / /  |/ /\__ \ 
     / ___ / /___  / / _/ // /_/ / /|  /___/ / 
    /_/  |_\____/ /_/ /___/\____/_/ |_//____/
    */

    //app initial page
    public function indexAction()
    {
	$request = $this->getRequest();
	$session = $this->getRequest()->getSession();
 	$logger = $this->get('logger');
	     	  	   
	
  	   
	//facebook parameters
	$app_id = $this->container->getParameter('facebook_app_id');
   	$app_secret = $this->container->getParameter('facebook_secret');
   	if (strpos($this->getRequest()->getUri(), '443')) {
	    $app_url = $this->container->getParameter('facebook_app_sec_url');
	    $real_url = "https://www.lobama.com/Symfony/web/app_dev.php/logout";
	}
	else {
	    $app_url = $this->container->getParameter('facebook_app_url');
            $real_url = "http://www.lobama.com/Symfony/web/app_dev.php/logout";
	}
	
	$this->facebookAction();
	//var_dump($this->getRequest()->cookies);
	$userId = $this->isFacebookSessionValid();
	
	if($userId) { 
	    $facebook = $this->get("Facebook");
	    //get facebook user locale
	    $fblocale = $this->fqlUserLocale();
	 
	    //set site locale
            if(!$fblocale) {
            	$this->get('session')->setLocale('en');
            }
            else {
        	$this->get('session')->setLocale($fblocale);
            }
	
   	    //get logout url
	    $logout_url = $facebook->getLogoutUrl(array('next' => $real_url));
	    //var_dump($decoded_response);
	    //var_dump($this->collectUserAlbumsFromFacebook($userId));
	    //$posterResultSet =  $this->collectUserAlbumsFromFacebook($userId);
	    
	    //$iter = count($posterResultSet) - 1;
	}
	else {
	    $logout_url = '';
	}		
	    
	return $this->render('LobamaSocial2PrintBundle:Default:index.html.twig', array(
            'name' => $userId,
	    'logout_url' => $logout_url,
	));
	    
    }

    public function facebookAction() 
    {
	$request = $this->getRequest();
        $session = $this->getRequest()->getSession();
        $logger = $this->get('logger');


        //facebook parameters
        $app_id = $this->container->getParameter('facebook_app_id');
        $app_secret = $this->container->getParameter('facebook_secret');
        if (strpos($this->getRequest()->getUri(), '443')) {
             $app_url = $this->container->getParameter('facebook_app_sec_url');
             $real_url = "https://www.lobama.com/Symfony/web/app_dev.php/logout";
        }
        else {
             $app_url = $this->container->getParameter('facebook_app_url');
             $real_url = "http://www.lobama.com/Symfony/web/app_dev.php/logout";
        }
        //var_dump(strpos($this->getRequest()->getUri(), '443'));
           //if there is code it means the user is authenticated
        $code = $request->query->get('code');
	$dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
           . $app_id . "&redirect_uri=" . urlencode($app_url) . "&state="
           . $session->get('state')
           . "&scope="
           . "email,"
           . "read_stream,"    // Likes,
           . "user_photos,"    // Users Albums
           . "friends_photos,"  // Friends Albums
                  //    . "user_checkins,"
                  //    . "friends_checkins,"
                  //    . "user_relationships,"  // Family
                  //    . "user_groups,"  // 
                  //    . "friends_groups,"  // 
           . "user_likes,"  // 
           . "friends_likes";
	
	if(empty($code)) {
           $session->set('state' ,md5(uniqid(rand(), TRUE))); //CSRF protection
           $logger->info($session->get('state'));
           
           echo("<script> top.location.href='" . $dialog_url . "'</script>");
        }
	
        //Get the user to authenticate if not already
        if($session->get('state') && ($session->get('state') === $request->query->get('state'))) {
           $token_url = "https://graph.facebook.com/oauth/access_token?"
           . "client_id=" . $app_id . "&redirect_uri=" . urlencode($app_url)
           . "&client_secret=" . $app_secret . "&code=" . $code;

           $logger->info("Trying to get a token. Open: " . $token_url);
           $response = file_get_contents($token_url);
           $params = null;
           parse_str($response, $params);
	   
           $logger->info('We got an access_token'.$params['access_token']);
           //Query the graph
           $graph_url = "https://graph.facebook.com/me?access_token="
           . $params['access_token'];
	  
           $access_token = $params['access_token'];
           $response = $this->curl_get_file_contents($graph_url);
           $decoded_response = json_decode($response);
	
	//Check for errors and return response
           if (isset($decoded_response->error)) {
              $logger->info("The attempt to query the graph resulted in an error: " . $decoded_response->error->type);

              // check to see if this is an oAuth error:
              if ($decoded_response->error->type== "OAuthException") {

                 // Retrieving a valid access token. 
                 $logger->info("OAuthException: Try to retrieve a valid access_token.");
                 $logger->info("Redirecting to dialog_url: ". $dialog_url);                      //if the page is being rendered in facebook canvas page 
                 return new Response('<html><head><script>top.location.href="'.$dialog_url.'"</script></head><body></body></html>');
                 //return $this->redirect($dialog_url);
          	}
              else {
            	$logger->err("Another error occured in posterActions." . $decoded_response->error->type);
           	throw new \Exception('initFacebookSessionAction: Sorry. We got an error but it was no OAuthException');
              }
    	   }
	   else {
		$logger->info("The attempt to query the graph was successful. Storing the acces_token in user session: " . $access_token);
                $logger->info("Facebook is ready. Redirecting to index page");
                
                $session->set('access_token'.$app_id, $access_token);
		
		//$this->getResponse()->setCookie('fb'.$app_id, $access_token);
		return $this->redirect($this->generateUrl('_index'));
	   }
	   $logger->err("Error in initFacebookSessionAction, this error should not orrur");
           throw new \Exception('initFacebookSessionAction: Sorry. Soemthing went wrong');
        }
        else {
           return new Response('<html><head></head><body>The state does not match. You may be a victim of CSRF.</body></html>');
           //echo("The state does not match. You may be a victim of CSRF.");
        }
    }
 
    public function logoutAction() 
    {
	if (strpos($this->getRequest()->getUri(), '443')) {
                //$app_url = $this->container->getParameter('facebook_app_sec_url');
                $real_url = "https://www.lobama.com/Symfony/web/app_dev.php";
        }
        else {
                //$app_url = $this->container->getParameter('facebook_app_url');
                $real_url = "http://www.lobama.com/Symfony/web/app_dev.php";
        }
	
	return $this->redirect($real_url);
    }

    // The page where the user selects product
    public function productAction() 
    {
	$logger = $this->get('logger');
	$facebook = $this->get('Facebook');
 	$logout_url = $this->getFbLogoutUrl();
	
	
	
	
	return $this->render('LobamaSocial2PrintBundle:Default:product.html.twig', array(
	    'logout_url' => $logout_url,
	));

    }

    // The page where the user sets the poster options
    public function optionsAction() {
	$logger = $this->get('logger');
        $facebook = $this->get('Facebook');
        $logout_url = $this->getFbLogoutUrl();


	return $this->render('LobamaSocial2PrintBundle:Default:options.html.twig',array(
            'logout_url' => $logout_url,
        )); 
    }

    // Render the loading screen with its AJAX calls
    public function loadingAction() {
	// Prepare action services
        $logger = $this->get('logger');
	$session = $this->getRequest()->getSession();
        $logout_url = $this->getFbLogoutUrl();
	var_dump($this->getRequest()->query);

	// FAKE 100%, 
        $session->set('loading_progress', '100');
	$session->set('layout', $this->getRequest()->query->get('size'));	

	return $this->render('LobamaSocial2PrintBundle:Default:loading.html.twig',array(
            'logout_url' => $logout_url,
        ));
    }
    
    
    public function createPosterAction() {
	// Prepare action services
        $logger     =   $this->get('logger');
        $session    =   $this->getRequest()->getSession();
        $em         =   $this->getDoctrine()->getEntityManager();

	// If we don't have a valid facebook session initiate it
        $fbUserId = $this->isFacebookSessionValid();
        
	$session->set('loading_progress', '100');
	

	// Feed our databases with data from facebook
        $user = $this->collectFacebookPosterData($fbUserId);
	
	//get an ordered list of relevant objects for poster
	$posterResultSet = $this->posterQueryEngine($fbUserId);
	
	//get the layout that the user selected
	$layout = $this->loadChosenLayout($posterResultSet);
	if (!$layout) {
            $logger->err($this->loggerDecorator("There is no layout for facebok user: " . $fbUserId));
            return new Response(json_encode(array('redirectURL' => $this->generateUrl('_not_enough_photos'))));
        }
		
	// Create the poster object
        $poster = $this->createPosterWithLayout($posterResultSet, $layout, $user);
	$logger->info($this->loggerDecorator("Poster successful created: " . $poster->getId() ));

        // Download Previw Image to local file system and store local file path into DB
        $this->downloadPreviewImages($posterResultSet, $poster->getId());
	
	// Set posterId in session
        $session->set('poster_id', $poster->getId());

	return new Response(json_encode(array('redirectURL' => $this->generateUrl('_preview'))));
    }

     // This action is called during the create action and delivers the actual value of the backgroudn preparation (creation) progress
    // BUG / TODO: This doesn't work currently. The session updated by the create action is not updated during runtime 
    public function loadingProgressAction()
    {
        // Prepare action services
        $session    =   $this->getRequest()->getSession();
        
        // Get progress from user session
        $progress   =   $session->get('loading_progress');
        
        // Respond with current progress
        return new Response(json_encode(array('progress' => $progress)));
    }

    
    // Show the poster Preview
    public function previewAction()
    {
        // Preparing the Facebook Logout URL
        $logout_url = $this->getFbLogoutUrl();
        
        // Get the current users poster
        $poster = $this->getPosterFromSessionAndFacebookID(); 
        
        // Prepare JSON result
        $json = $this->JSONPoster($poster);
        
        return $this->render('LobamaPosterBundle:Default:preview.html.twig', array(
            'json' => $json, 
            'logout_url' => $logout_url, 
        ));
    }

    // If the user has not enough photos to use social2print (no layout with available user photos available) show this
    public function notEnoughPhotosAction()
    {
        return $this->render('LobamaPosterBundle:Default:error.html.twig');
    }
    
    /*
        __  __________    ____  __________ 
       / / / / ____/ /   / __ \/ ____/ __ \
      / /_/ / __/ / /   / /_/ / __/ / /_/ /
     / __  / /___/ /___/ ____/ /___/ _, _/ 
    /_/ /_/_____/_____/_/   /_____/_/ |_|  

        ________  ___   ______________________  _   _______
       / ____/ / / / | / / ____/_  __/  _/ __ \/ | / / ___/
      / /_  / / / /  |/ / /     / /  / // / / /  |/ /\__ \ 
     / __/ / /_/ / /|  / /___  / / _/ // /_/ / /|  /___/ / 
    /_/    \____/_/ |_/\____/ /_/ /___/\____/_/ |_//____/  

    */

     // Download all preview images we use in a stack
    // - Lets us use clean https (Facebook images are available through http only)
    // - Speeds up the preview pdf (share image) creation
    // - TODO: Rethink the method to get the image local and public folder
    // - TODO: Create a folder for each poster or facebeook_uid (I guess large folder will perform badly later when we have 100.000 of photos in only one folder)
    private function downloadPreviewImages($posterResultSet, $posterId) {
      $totaltime = 0;
      // Prepare action services
      $em = $this->getDoctrine()->getEntityManager();
      $logger     =   $this->get('logger');
      $logger->info($this->getRequest()->getScheme()."://"
                    .$this->getRequest()->headers->get('host'));
      // Use 'poster_photo_facebook_preview_size' image to copy to local file system
      $previewImageSize = $this->container->getParameter('poster_photo_facebook_preview_size');

      foreach($posterResultSet['photos'] as $key => $photo) {
        $start = microtime(true);
        $previewPhoto = $photo->getLocalPreviewImage();
        $localPhoto = str_replace($this->getRequest()->getScheme()."://"
                    .$this->getRequest()->headers->get('host'), '/var/www/html', $previewPhoto);

        // if the local file does not exist
        if(!$previewPhoto || !is_readable($localPhoto))
        {
            // Get ID of current photo
            $photoId = $photo->getId();

            // Get facebook image url of preview sized image 
            $images = $photo->getImages();
            $src = $images[$previewImageSize]['source'];

            // Copy image to local file system
            // Prepare folder for preview images
            $imgPreviewFolder = $this->container->getParameter('preview_image_public_folder');
            // Image file name
            $imgFileName = 'pid';
            $imgFileName .= $posterId;
            $imgFileName .= '_';
            $imgFileName .= $photoId . '_p.jpg';
 	
  	    $imgFile = $imgPreviewFolder.$imgFileName;

	    $ch = curl_init($src);
            $fp = fopen($imgFile ,"w");

            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $url =   $this->getRequest()->getScheme()."://"
                    .$this->getRequest()->headers->get('host')
                    .$this->getRequest()->getBasePath()
                    ."/preview_images/".$imgFileName;

            // Prepare to store local filename into DB
            $photo->setLocalPreviewImage($url);
            $em->persist($photo);
            //measure download time
	    $end = microtime(true);
            $diff = $end - $start;
	    $logger->info('Image '.$photoId.' downloaded for '.$diff.' seconds');
        $totaltime+=$diff;
        }

      }

      // Store into DB
      $em->flush();
      $logger->info('Images downloaded for '.$totaltime.' seconds');
      return true;
    }


    /*
     * Calculates the offset of an image to fit into a tile
     * The dimension of the offset is stored in building blocks
     *
     */
    private function calculateOffsetBB($imageSize, $tileSize, $blockSize)
    {
      $offsetPx = - ( $imageSize - $tileSize ) / 2;
      $offsetBB = $offsetPx / $blockSize;
      return $offsetBB;
    }

    protected function createPosterWithLayout($posterResultSet, $layout, $user) 
    {

        if (!isset($posterResultSet)) {
          throw new \InvalidArgumentException('You must provide a posterResultSet');
        }
        if (!isset($layout)) {
          throw new \InvalidArgumentException('You must provide a layout');
        }
        if (!isset($user)) {
          throw new \InvalidArgumentException('You must provide a user');
        }

        // Prepare action services
        $em = $this->getDoctrine()->getEntityManager();
        $session    =   $this->getRequest()->getSession();
        $logger     =   $this->get('logger');
        
        // Get configuration and tile list from layout
        $config = $layout['config'];
        $labels = $layout['labels'];
        $tiles = $layout['tiles'];
    
        // Calculate the posters building block size
        $posterSize = $config['size'];
        $posterReferenceSizeCm = $this->container->getParameter('poster_reference_size_cm');
        $posterPhotoDpiLimit = $this->container->getParameter('poster_photo_dpi_limit');
        $buildingBlockReferenceWidthCm = $posterReferenceSizeCm['width']/$posterSize['cols'];
        $buildingBlockReferenceHeightCm = $posterReferenceSizeCm['height']/$posterSize['rows'];
        $buildingBlockPixelsWidth = $buildingBlockReferenceWidthCm * $posterPhotoDpiLimit / 2.54; 
        $buildingBlockPixelsHeight = $buildingBlockReferenceHeightCm * $posterPhotoDpiLimit / 2.54; 
    
        // Create a new Poster
        $poster = new Poster();
        $poster->setConfig($config);
        $poster->setStatus("preview");
        $poster->setUser($user);
        
        // Overwrite defualt subtitle textline with user name
        $labels[0]['textlines'][1]['value'] = $user->getName();
        $poster->setLabels($labels);

        // Sort layout tiles by priority (Sort the multidimensional array)
        // http://www.php.net/manual/de/function.array-multisort.php
        // -> Convert rows to columns to be able to sort
        foreach ($tiles as $key => $row) {
            $h_coords[$key]   = $row['coords'];
            $h_dim[$key]      = $row['dim'];
            $h_type[$key]     = $row['type'];
            // If there is no priority given -> randomize between 1000..2000. Each tile with priority less 1000 will beat these randomized tiles
            if(!isset($row['priority'])) $row['priority'] = rand(1000,2000);
            $h_priority[$key] = $row['priority'];
        }
        array_multisort($h_priority, SORT_NUMERIC, $tiles);
        
        
        // Create an array with all photos in prioritized order (see array_multisort above) 
        // The array acts as a stack of photos. Best photos on top of the stack.
        // Each photo we use will be removed from the stack.
        foreach($posterResultSet['photos'] as $key => $photo) {
            $photoStack[$key] = $photo;
            $logger->info($this->loggerDecorator("Photostack[".$key."] = PhotoID: ".$photo->getId()));
        }
        
        
        // Key: Low key means high priority tile, because tiles are sorted by priority
        // Key: Low key also means high priority object, becaus objects are sorted by totalScore
        foreach($tiles as $key => $tile) {
            
            // Add photos to poster
            if($tile['type'] == 'photo') {
                
                // Create a new PosterPhoto
                $posterPhoto = new PosterPhoto();
                
                // Get tile dimension from layout
                $tileWidth = $tile['dim'][0];
                $tileHeight = $tile['dim'][1];
                
                // Run through the photo stack. To start with best photo reset stack.
                reset($photoStack);
                $photoFits = false;
                foreach($photoStack as $key => $photo) {
                    
                    $logger->info($this->loggerDecorator("Trying to fit Photo ID ".$photo->getId()));
                    
                    // Get image dimension from image
                    $images = $photo->getImages();
                    $fullsizePosition = $this->container->getParameter('poster_photo_facebook_original_size');;
                    $imageWidth = $images[$fullsizePosition]['width'];
                    $imageHeight = $images[$fullsizePosition]['height'];
                    
                    // If the size (resolution) of the photo is better than the tile requires 
                    if ( $imageWidth >= $tileWidth * $buildingBlockPixelsWidth  && $imageHeight >= $tileHeight * $buildingBlockPixelsHeight) {
                    
                        $logger->info($this->loggerDecorator("Tile[".$tile['coords'][0]."][".$tile['coords'][1]."] gets fitting Photo with ID: ".$photo->getId()));
                    
                        // Use current photo for current tile
                        $posterPhoto->setPhoto($photo);
                        $photoFits = true;
                        // Remove used photo from stack
                        unset($photoStack[$key]);
                        // Stop seach for best fitting photo
                        break;
                    }
                    
                }
                
                // If we reach the end of the stack w/o finding a fitting photo
                // Use the first best photo and remove it from the stack, continue with next tile
                if (!$photoFits) {
                    reset($photoStack);
                    $photo = current($photoStack);
                    $posterPhoto->setPhoto($photo);
                    $logger->info($this->loggerDecorator("No fitting Photo for Tile[".$tile['coords'][0]."][".$tile['coords'][1]."] found. Using Photo with ID: ".$photo->getId()." instead"));
                    $key = key($photoStack);
                    unset($photoStack[$key]);
                    // TODO: Mark the selected photo as "not optimal"
                }
                
                // Calculate the building block pixel size
                $tileWidthPx = $tileWidth * $buildingBlockPixelsWidth;
                $tileHeightPx = $tileHeight * $buildingBlockPixelsHeight;
                
                // Get image orientation
                $imageOrientation = $this->getImageOrientation($imageWidth, $imageHeight);
                
                // Get fitted image dimension
                $fittedImageDimension = $this->getImageDimensionFittingIntoTile($imageWidth, $imageHeight, $tileWidthPx, $tileHeightPx);
                
                // Image offset in building blocks
                if ($imageOrientation == "l") {
                  $imageOffsetX = $this->calculateOffsetBB($fittedImageDimension['w'], $tileWidthPx, $buildingBlockPixelsWidth);
                  $imageOffsetY = 0;
                }
                if ($imageOrientation == "p") {
                  $imageOffsetX = 0;
                  
                  $logger->info("Calculate offsetBB - fittedImageDimension:" . $fittedImageDimension['h'] . " tileHeightPx:" .  $tileHeightPx ." buildingBlockPixelsHeight:".  $buildingBlockPixelsHeight );
                  $imageOffsetY = $this->calculateOffsetBB($fittedImageDimension['h'], $tileHeightPx, $buildingBlockPixelsHeight);
                  $logger->info("Result imageOffsetY: " . $imageOffsetY);
                }
                if ($imageOrientation == "s") {
                  $imageOffsetX = 0;
                  $imageOffsetY = 0;
                }
                
                // Set all other PosterFoto props
                $posterPhoto->setTileCoords(serialize(array('x'=>$tile['coords'][0], 'y'=>$tile['coords'][1])));
                $posterPhoto->setTileDim(serialize(array('w'=>$tile['dim'][0], 'h'=>$tile['dim'][1])));
                $posterPhoto->setPhotoScale('1');
                $posterPhoto->setPhotoOrientation($imageOrientation);
                $posterPhoto->setPhotoOffset(serialize(array('x'=>$imageOffsetX, 'y'=>$imageOffsetY)));
                $posterPhoto->setPoster($poster);
                $poster->addPosterPhoto($posterPhoto);
            }
            
            // For later usage: Add comments to poster
            if($tile['type'] == 'comment') {
                // $posterComment = new PosterComment();
                // …
            }
            
        }
        
        // Save poster with all photos
        $em->persist($poster);
        $em->flush();
        
        // Persist data of Photostack for later usage (replace photos)
        $session->set("photoStack", $photoStack);
        
        // Return generated poster object
        return $poster;
    }
    
    private function getImageOrientation($w, $h)
    {
      $o = ($w==$h) ? "s" : ($w>$h) ? "l" : "p";
      return $o;
    }

    //load the layout that the user choose
    protected function loadChosenLayout($posterResultSet) {
	//init action services
	$session = $this->getRequest()->getSession();
	$engine     =   $this->container->get('templating');
	$logger     =   $this->get('logger');
	
	//get layout size
	$size = $this->getRequest()->getSession()->get('layout');
	//remove from session
	$session->remove('layout');

	foreach($posterResultSet as $key => $resultSubSet) {
            if($key == 'photos') {
                $c = count($resultSubSet);
                // Check if the photo size is big enought for print
                // $posterReference = $posterReferenceWidth;
                // $posterReferenceWidth = $posterReference['width'];
                // $posterReferenceHeigth = $posterReference['height'];
                // $posterPhotoDpiLimit = $this->container->getParameter('poster_photo_dpi_limit');
                $countPhotos = count($resultSubSet);
                $logger->info($this->loggerDecorator("Searching for a poster layout for ".$countPhotos." photos"));

            }
	}

	// Get available layouts from configuration
        $availableLayouts = $this->container->getParameter('poster_layouts');

	// Crawl available layout and get min/max numver of photos
        foreach($availableLayouts as $key => $availableLayout) {
            $logger->info($this->loggerDecorator("Check layout: " . $availableLayout));
            $template = $engine->render('LobamaSocial2PrintBundle:PosterLayouts:'.$availableLayout.'.yml.twig');
            $layout[$key] = Yaml::parse($template);
            $logger->info($size);
	    $logger->info($layout[$key]['config']['layoutName']);
	    if ($size == $layout[$key]['config']['layoutName']) {
		if ($countPhotos < $layout[$key]['config']['minPhotos']) {
		    return false;
		}
		else {
		     return $layout[$key];
		}
	    }
        }

	// If we don't offer a layout return false
	return false;
    } 
    

    // AJAX: Here we collect the data and store them into our DB
    protected function collectFacebookPosterData($fbUserId)
    {

        if (!isset($fbUserId)) {
          throw new \InvalidArgumentException('You must provide a fbUserId');
        }

        // Prepare action services
        $logger     =   $this->get('logger');
        //$facebook   =   $this->get('Facebook');
        $session    =   $this->getRequest()->getSession();
        $em         =   $this->getDoctrine()->getEntityManager();

        // Get facebook data to + a poster 
        $fqlResult = $this->fqlQuery();

        // Retrieve the user table from the Facebook result. 
        $fbUserResult = $this->returnTableFromFqlResultSet('user', $fqlResult);
        $fbalbums = $this->returnTableFromFqlResultSet('userAlbums', $fqlResult);
        $fbphotos = $this->returnTableFromFqlResultSet('userImages', $fqlResult);
        $fblikes = $this->returnTableFromFqlResultSet('likes', $fqlResult);
        $fbcomments = $this->returnTableFromFqlResultSet('comments', $fqlResult);
	
	// Get existing S2P user or create a new one
        $user = $this->getOrCreateUserFromFacebookUserId($fbUserId, $fbUserResult, $em);
        $logger->info($this->loggerDecorator("S2P User ready: ". $user->getUsername()));

        // Prepare a PHP5 datetime object for doctrine2 datetime fields 
        $datetime = new \DateTime;

        // Get the Facebook like and comment Object from the ScoreType DB
        $stLike = $this->getDoctrine()->getRepository('LobamaSocial2PrintBundle:ScoreType')->findOneByName('Like');              
        $stComment = $this->getDoctrine()->getRepository('LobamaSocial2PrintBundle:ScoreType')->findOneByName('Comment');

        // Delete all old user data first
        // TODO: Clean up here. Learn how to work with relation and cascade. build a sandbax application to do this.
        // $dql = $em->createQuery("DELETE Lobama\BasicBundle\Entity\Photo p WHERE p.owner = ".$fbUserId);
        // $result = $dql->execute();

        // $dql = $em->createQuery("DELETE Lobama\BasicBundle\Entity\Album a WHERE a.owner = ".$fbUserId);
        // $result = $dql->execute();

        // Store Facebook data 
        foreach($fbalbums as $a)
        {

          $album = $this->getDoctrine()->getRepository('LobamaSocial2PrintBundle:Album')->findOneBy(array('object_id' => $a['object_id']));  
          if (!$album) {
            $album = new Album();
            $album->setObjectId($a['object_id']);
            $album->setAid($a['aid']);
            $album->setCoverObjectId($a['cover_object_id']);
            $album->setOwner($a['owner']);
            $album->setModifiedMajor($datetime->setTimestamp($a['modified_major']));
            $album->setKind($a['type']);
          }

          // Fetch albums photos
          foreach($fbphotos as $p) 
          {

            // If the photo belongs to the current album
            if($p['album_object_id'] == $a['object_id'])
            {

              $photo = $this->getDoctrine()->getRepository('LobamaSocial2PrintBundle:Photo')->findOneBy(array('object_id' => $p['object_id']));  
              if (!$photo)
              {
                $photo = new Photo();
                $photo->setObjectId($p['object_id']);
                $photo->setPid($p['pid']);
                $photo->setAid($p['aid']);
                $photo->setAlbumObjectId($p['album_object_id']);
                $photo->setOwner($p['owner']);
                $photo->setCreated($datetime->setTimestamp($p['created']));
                $photo->setModifiedLast($datetime->setTimestamp($p['modified']));
                $photo->setImages($p['images']);
                $photo->setAlbum($album);
                $album->addPhoto($photo);

                // Fetch photos likes
                foreach($fblikes as $l) 
                {
                  if($l['object_id'] == $p['object_id'])
                  {
                    $like = new Score();
                    $like->setOriginObjectId($l['object_id']);
                    $like->setScoreType($stLike);
                    // Attach current like to photo
                    $like->setPhoto($photo);
                    $photo->addScore($like);
                  }
                }

                // Fetch photos comments
                foreach($fbcomments as $c) 
                {
                  if($c['object_id'] == $p['object_id'])
                  {
                    $comment = new Score();
                    $comment->setOriginObjectId($c['object_id']);
                    $comment->setScoreType($stComment);
                    // Attach current comment to photo
                    $comment->setPhoto($photo);
                    $photo->addScore($comment);
                  }
                }

              } // !$photo

            } // EndIf the photo belongs to the current album
          } // EndForEach Fetch albums photos

          // Save album with all photos
          $em->persist($album);
          $em->flush();

        } // End: Store Facebook data 

        $logger->info($this->loggerDecorator("All poster data stored in DB"));
        return $user;
    }
    
    
    //generate Facebook logout url
    protected function getFbLogoutUrl() {
	$facebook = $this->get('Facebook');
	if (strpos($this->getRequest()->getUri(), '443')) {
            $real_url = "https://www.lobama.com/Symfony/web/app_dev.php/logout";
        }
        else {
            $real_url = "http://www.lobama.com/Symfony/web/app_dev.php/logout";
        }

	$logout_url = $facebook->getLogoutUrl(array('next' => $real_url));	
	
	return $logout_url;
    }

    // Get user account or create one 
    protected function getOrCreateUserFromFacebookUserId($fbUserId, $fbUserTable, $em)
    {
	$user = $this->getUserFromFacebookUserId($fbUserId);
	if(!$user) {
            // Create user account
    		$user = new User();
    		$user->setFacebookuid($fbUserTable[0]['uid']);
    		$user->setUsername($fbUserTable[0]['username']);
    		$user->setName($fbUserTable[0]['name']);
    		$user->setLocale($fbUserTable[0]['locale']);
    		$user->setEmail($fbUserTable[0]['email']);
    		$user->setThirdPartyId($fbUserTable[0]['third_party_id']);
    		// save data to db
    		$em->persist($user);
            $em->flush();
        }

        return $user;
    }

    // Get user account or create one 
    protected function getUserFromFacebookUserId($fbUserId)
    {   
	$user = $this->getDoctrine()->getRepository('LobamaSocial2PrintBundle:User')->findOneByFacebookuid($fbUserId);
        
	if(!$user) {
            return false;
}
        else {
            return $user;
        }
    }

    protected function posterQueryEngine($fbUserId)
    {

        // We need a more sophisticated query engine. 
        // The query engine itself should be moved into a separate bundle / project / server
        // The engine should deliver results based on query parameters, maybe via an API

        // Prepare Doctrine entity manager
        $em = $this->getDoctrine()->getEntityManager();

        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('Lobama\Social2PrintBundle\Entity\Photo', 'p');
        $rsm->addFieldResult('p', 'id', 'id');
        $rsm->addFieldResult('p', 'images', 'images');
        //$rsm->addScalarResult('totalscore', 'totalscore');

        $query = $em->createNativeQuery(
                'SELECT id,
                        images,
                        SUM(f*c) AS totalscore
                        FROM (SELECT p.id AS id, p.images AS images,
                                st.factor AS f,
                                COUNT(p.id) AS c 
                            FROM s2p_basic_photo p 
                            LEFT JOIN s2p_basic_score s on s.Photo_id = p.id
                            LEFT JOIN s2p_basic_score_type st on s.ScoreType_id = st.id
                            WHERE p.owner = '.$fbUserId.'
                            GROUP BY p.id, st.name
                        ) AS baseview
                GROUP BY id
                ORDER BY totalscore DESC
                LIMIT '.$this->container->getParameter('poster_query_engine_photo_limit')
        ,$rsm);
        $photos = $query->getResult();

        $resultSet = array(
            'photos'    =>  $photos,
        );
        return $resultSet;
    }

    // This function checks if a valid access token is available. 
    // If not it returns false and you will need to initiate the Facebook authentification.
    protected function isFacebookSessionValid() {
	$session = $this->getRequest()->getSession();
      	$logger = $this->get('logger');
      
	// First: Try to get the access_token from session
    	$access_token = $session->get('_fos_facebook_fb_'.$this->container->getParameter('facebook_app_id').'_access_token');
		
    	if ($access_token) {
    	    $logger->info("We have a access_token: " . $access_token);
    	    $this->get('Facebook')->setAccessToken($access_token);
    	}
    	else {
    	    $logger->info("No access_token given");
    	    $this->facebookAction();
	}

    	// Second: Try to get User ID from facebook
        $facebook = $this->get('Facebook');
	$fbUserId = $facebook->getUser();
	  
	if($fbUserId) {
	    try {
                  // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $this->get('Facebook')->api('/me');
      	        $logger->info("The facebook session is valid");
      	        return $fbUserId;
              } catch (FacebookApiException $e) {
      			$logger->err("We have a user but an error occured: " . $e);
      			$this->facebookAction();
              }
	}
	else {
	    $this->facebookAction();
	}	
    }

    // note this wrapper function exists in order to circumvent PHP’s 
    // strict obeying of HTTP error codes.  In this case, Facebook 
    // returns error code 400 which PHP obeys and wipes out 
    // the response.
    protected function curl_get_file_contents($URL)
    {
      	$c = curl_init();
      	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
      	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
      	curl_setopt($c, CURLOPT_URL, $URL);
      	$contents = curl_exec($c);
      	$err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
      	curl_close($c);
      	if ($contents) return $contents;
      	else return FALSE;
    }


    /**
     * Call facebook api to retrieve user's language.
     * @return string user's language
     */
    protected function fqlUserLocale()
    {
        $facebook   =   $this->get('Facebook');

	//prepare query
        $fql    = '{
            "user"          : " SELECT locale FROM user WHERE uid = me()"
        }';

        $param  =   array(
            'method'    => 'fql.multiquery',
            'queries'   => $fql,
            'callback'  => ''
        );

	//execute query
        try {
           $fqlResult   =   $facebook->api($param);
        }
        catch (FacebookApiException $e) {
           $logger->err("fqlPosterQuery FacebookApiException: " . $e);
           throw new \Exception('fqlPosterQuery: ' . $e);
        }

        return $fqlResult[0]['fql_result_set'][0]['locale'];
    }

    /**
     * Call facebook api to retrieve user's albums, photos, likes and comments about them.
     * @return array facebook result 
     */
    
    protected function fqlQuery(){
	$logger     =   $this->get('logger');
        $facebook   =   $this->get('Facebook');
	//$facebook->setAccessToken($this->getRequest()->cookies->get('fb'.$this->container->getParameter('facebook_app_id')));
	$facebook->setAccessToken($this->getRequest()->getSession()->get('_fos_facebook_fb_'.$this->container->getParameter('facebook_app_id').'_access_token'));	
	
        $fql    = '{
            "user"          : " SELECT uid, username, name, locale, email, third_party_id FROM user WHERE uid = me()",
	    "userAlbums"    : " SELECT object_id, aid, cover_object_id, owner, modified_major, type FROM album WHERE owner = me()",
            "userImages"    : " SELECT object_id, pid, aid, album_object_id, owner, created, modified, images FROM photo WHERE aid IN (SELECT aid FROM #userAlbums)",
            "likes"         : " SELECT object_id, user_id FROM like WHERE object_id IN (SELECT object_id FROM #userImages)",
            "comments"      : " SELECT object_id, fromid FROM comment WHERE object_id IN (SELECT object_id FROM #userImages)",
	    "images" 	    : " SELECT images from #userImages"   
      	}';

        $param  =   array(
            'method'    => 'fql.multiquery',
            'queries'   => $fql,
            'callback'  => ''
        );

      $logger->info("FQL fqlQuery request started: ". $param);
		
      try {
           $fqlResult   =   $facebook->api($param);
      } 
      catch (FacebookApiException $e) {
           $logger->err("fqlPosterQuery FacebookApiException: " . $e);
           throw new \Exception('fqlPosterQuery: ' . $e);
      }
        
		return $fqlResult;

    }

    protected function collectUserAlbumsFromFacebook($userId){
	
 	if (!isset($userId)) {
          throw new \InvalidArgumentException('You must provide a fbUserId');
        }

	$logger     =   $this->get('logger');
	
	//get facebook photos data
	$fqlResult = $this->fqlQuery();

	//retrieve user tables from fqlQuery
	$fbalbums = $this->returnTableFromFqlResultSet('userAlbums', $fqlResult);
        $fbphotos = $this->returnTableFromFqlResultSet('userImages', $fqlResult);
        $fblikes = $this->returnTableFromFqlResultSet('likes', $fqlResult);
        $fbcomments = $this->returnTableFromFqlResultSet('comments', $fqlResult);
    	$images = $this->returnTableFromFqlResultSet('images', $fqlResult);
	
	//fill array with images' sources
	//var_dump($fblikes);
	//var_dump($fbcomments);
	$stack = array();
	
        //foreach($images as $key => $image) {
        //	array_push($stack, $image['images'][4]['source']);
        //}
	
	for ( $i = 0; $i < count($fbphotos); $i += 1) {
		$stack[$i] = array();
		$stack[$i]['src'] = $fbphotos[$i]['images']['6']['source'];
		$stack[$i]['likes'] = 0;
		$stack[$i]['comments'] = 0;
		$stack[$i]['both'] = 0;
		foreach($fblikes as $key => $likes){
			if ($likes['object_id'] == $fbphotos[$i]['object_id'])
				$stack[$i]['likes'] = $stack[$i]['likes'] + 1;
		}
		foreach($fbcomments as $key => $comments){
                        if ($comments['object_id'] == $fbphotos[$i]['object_id'])
                                $stack[$i]['comments'] = $stack[$i]['comments'] + 1;
                		//var_dump($stack[$i])
		}
		$stack[$i]['both'] = $stack[$i]['likes'] + $stack[$i]['comments'];
	}
	$keys = array_map(function($val) { return $val['both']; }, $stack);
	array_multisort($keys, SORT_DESC, $stack);
	//$stack = array_slice($stack, $page*20-20, 20);
	
	return $stack;
    }

    /*returns seperate resultsets as table from common fb resultset
     *@param table string name of the table
     *@param fqlResult array facebook resultset
     *@return array seperate resultset with table's name if exists in common resultset
     */
     
    protected function returnTableFromFqlResultSet($table, $fqlResult)
    {
        foreach($fqlResult as $r) {
            $tableName = $r['name'];
            if ($tableName == $table) {
                return $r['fql_result_set'];
            }
        }
        throw new \InvalidArgumentException('There is no table called "'.$table.'" in the Facebook result.');
    }

    protected function getTileParameters($photosCount){
	

    }

    /*
     * Aim of this function is to calculate a integer value for the preview poster building block width and height
     * We need this because we get white lines inside the preview if we don't use integer values for pixel positioning
     *
     * @return array => posterPreviewWidth, posterPreviewHeight
     */
    private function calculatePosterPreviewSize($poster)
    {

      // Get max preview size from config 
      $ms = $this->container->getParameter('poster_canvas_max_size_px');

      // Get the config of the poster
      $config = $poster->getConfig();

      // Calculate the max building block side lenght fitting into the max poster width
      $ps['width'] = floor($ms['width'] / $config['size']['cols']) * $config['size']['cols'];
      $ps['height'] = floor($ms['height'] / $config['size']['rows']) * $config['size']['rows'];

      return $ps;
    }

    /**
     * Logging in a different colour than Symfony itself helps to find own logging messages
     * @param string logMessage <p>Message for the logger to display</p>
     * @return string coloured log message (in this case in red)
     */
    protected function loggerDecorator($logMessage)
    {
        return "\033[01;31m ".$logMessage."\033[0m";
    }

    private function getImageDimensionFittingIntoTile($imageWidth, $imageHeight, $tileWidthPx, $tileHeightPx)
    {
      
      // Falls das Objekt schmaler als das Tile ist es so vergrößern, dass es in das Tile passt.
      if ($imageWidth < $tileWidthPx) {
        $i = $tileWidthPx/$imageWidth;
        $imageWidth = $imageWidth*$i;
        $imageHeight = $imageHeight*$i;
      }
      // Falls das Objekt kleiner als das Tile ist es so vergrößern, dass es in das Tile passt.
      if ($imageHeight < $tileHeightPx) {
        $i = $tileHeightPx/$imageHeight;
        $imageHeight = $imageHeight*$i;
        $imageWidth = $imageWidth*$i;
      }
      // Falls das Bild (h && w) größer ist als das Tile, dass so verkleinern, dass es passt.
      if ($imageWidth > $tileWidthPx || $imageHeight > $tileHeightPx) {
        $imageOrientation = $this->getImageOrientation($imageWidth, $imageHeight);
        if ($imageOrientation == "l") {
          $i = $imageHeight/$tileHeightPx;
          $imageHeight = $imageHeight/$i;
          $imageWidth = $imageWidth/$i;
        }
        if ($imageOrientation == "p") {
          $i = $imageWidth/$tileWidthPx;
          $imageWidth = $imageWidth/$i;
          $imageHeight = $imageHeight/$i;
        }
      }
      return array("w" => $imageWidth, "h" => $imageHeight);
    }

    protected function getPosterFromSessionAndFacebookID()
    {

        // Prepare action services
        $logger     =   $this->get('logger');
        $em         =   $this->getDoctrine()->getEntityManager();
        $session    =   $this->getRequest()->getSession();

        // If we don't have a valid facebook session initiate it
        $fbUserId = $this->isFacebookSessionValid();
        
        if ($fbUserId) {
  	    // Get posterId from session
            $posterId   =   $session->get('poster_id');
            if (!$posterId) {
            	throw new \InvalidArgumentException('You must provide a posterId: The session does not provide a poster_id.');
            }

            // Secure the poster: Get the actual User from the active Facebook Sessione
            // and get the Poster by ID
            $user = $this->getDoctrine()->getRepository('LobamaSocial2PrintBundle:User')->findOneByFacebookuid($fbUserId);
            if(!$user) {
            	$logger->info($this->loggerDecorator("previewAction: The query returned no user"));
            	throw new \Exception('No user found for Facebook ID: '. $fbUserId);
            }

            $poster = $this->getDoctrine()->getRepository('LobamaSocial2PrintBundle:Poster')->findOneBy(array(
            	'id' => $posterId,
            	'User' => $user->getId(),
            ));        
            if(!$poster) {
            	$logger->info($this->loggerDecorator("previewAction: The query returned no poster"));
            	throw new \Exception('The current user with id: '. $user->getId() .' seems not to be the owner of the poster with id: '. $posterId);
            }

            // Return the poster object
            return $poster;

	}
    }
	
     // JSON result of poster
    protected function JSONPoster($poster)
    {

        if (!isset($poster)) {
          throw new \InvalidArgumentException('You must provide a poster');
        }

        if (!defined("CM_INCH_RATIO")) {
          define("CM_INCH_RATIO", 2.54);
        }

        // Load data from Poster and prepare for JSON 
        $config = $poster->getConfig();
        $json['config'] = $config;

        // Reference size of poster (pt to convert the reference font size to px)
        $posterReferenceDpi = $this->container->getParameter('poster_reference_dpi');
        $posterReferenceSizeCm = $this->container->getParameter('poster_reference_size_cm');
        $posterReferenceSizeHeightCm = $posterReferenceSizeCm['height'];
        $posterReferenceSizeHeightPt = $posterReferenceSizeHeightCm / CM_INCH_RATIO * $posterReferenceDpi;

        $posterCanvasSizePx = $this->calculatePosterPreviewSize($poster);
        $posterCanvasSizeWidthPx = $posterCanvasSizePx['width'];
        $posterCanvasSizeHeightPx = $posterCanvasSizePx['height'];
        $json['config']['posterCanvasSizePx']['width'] = $posterCanvasSizeWidthPx;
        $json['config']['posterCanvasSizePx']['height'] = $posterCanvasSizeHeightPx;

        // Calculate the fontsize ratio to convert pt to px 
        // $posterHeightPtToPxRatio = $posterReferenceSizeHeightPt / $posterCanvasSizeHeightPx;

        // Scales
        $posterCanvasBuildingBlockWidthPx =  $posterCanvasSizeWidthPx / $config['size']['cols'];
        $posterCanvasBuildingBlockHeightPx =  $posterCanvasSizeHeightPx / $config['size']['rows'];
        $json['config']['buldingBlockPx']['width'] = $posterCanvasBuildingBlockWidthPx;
        $json['config']['buldingBlockPx']['height'] = $posterCanvasBuildingBlockHeightPx;
        // $json['config']['fontScalePtToPx'] = $posterHeightPtToPxRatio;

        // Labels
        $labels = $poster->getLabels();
        if($labels) {
            foreach($labels as $key => $label) {
                $json['labels'][$key] = $label;
                $json['labels'][$key]['coords'][0] *= $posterCanvasBuildingBlockWidthPx;
                $json['labels'][$key]['coords'][1] *= $posterCanvasBuildingBlockHeightPx;
                $json['labels'][$key]['dim'][0] *= $posterCanvasBuildingBlockWidthPx;
                $json['labels'][$key]['dim'][1] *= $posterCanvasBuildingBlockHeightPx;
                $json['labels'][$key]['url'] = $this->createTextLabelImage($poster);
            }
        }

        // Get Objects from Poster
        $posterPhotos = $poster->getPosterPhotos();

        // Configuration which image to use in HTML preview
        $htmlImageSize = $this->container->getParameter('poster_photo_facebook_preview_size');

        // Note: PosterPhotos should be PosterObjects (photoCoords => objCoords, photoDim => objDim, photoOffset => objOffset)
        foreach($posterPhotos as $key => $posterPhoto) {

            $objCoords = unserialize($posterPhoto->getTileCoords());
            $objDim = unserialize($posterPhoto->getTileDim());
            $photoOffset = unserialize($posterPhoto->getPhotoOffset());

            // Template === Tile
            $tile['x'] = $posterCanvasBuildingBlockWidthPx*$objCoords['x'];
            $tile['y'] = $posterCanvasBuildingBlockHeightPx*$objCoords['y'];
            $tile['w'] = $posterCanvasBuildingBlockWidthPx*$objDim['w'];
            $tile['h'] = $posterCanvasBuildingBlockHeightPx*$objDim['h'];

            // Image === Object
            $image = $this->generateJSONTileObject($posterPhoto, $tile['w'], $tile['h'], $posterCanvasBuildingBlockWidthPx, $posterCanvasBuildingBlockHeightPx);

            //JSON
            $json['tiles'][$key]['type'] = 'photo';
            $json['tiles'][$key]['id'] = $posterPhoto->getId();
            $json['tiles'][$key]['coords'][0] = intval($tile['x']);
            $json['tiles'][$key]['coords'][1] = intval($tile['y']);
            $json['tiles'][$key]['dim'][0] = intval($tile['w']);
            $json['tiles'][$key]['dim'][1] = intval($tile['h']);

            $json['tiles'][$key]['image']['orientation'] = $image['o'];
            $json['tiles'][$key]['image']['src'] = $image['src'];
            $json['tiles'][$key]['image']['dim'][0] = floatval($image['w']);;
            $json['tiles'][$key]['image']['dim'][1] = floatval($image['h']);
            $json['tiles'][$key]['image']['offset'][0] = floatval($image['offsetX']);
            $json['tiles'][$key]['image']['offset'][1] = floatval($image['offsetY']);

        }

        // JSON result
        return json_encode(array('posterData' => $json));

    }

    private function createTextLabelImage($poster) 
    {
        
        if (!isset($poster)) {
          throw new \InvalidArgumentException('You must provide a poster');
        }
        
        $logger     =   $this->get('logger');
        
        if (!defined("CM_INCH_RATIO")) {
            define("CM_INCH_RATIO", 2.54);
        }
        
        // Reference resolution
        $posterReferenceDpi = $this->container->getParameter('poster_reference_dpi');

        // Reference size of poster
        $posterReferenceSizeCm = $this->container->getParameter('poster_reference_size_cm');
        $posterReferenceSizeHeightCm = $posterReferenceSizeCm['height'];
        $posterReferenceSizeHeightPt = $posterReferenceSizeHeightCm / CM_INCH_RATIO * $posterReferenceDpi;

        $posterReferenceSizePx = $this->calculatePosterPreviewSize($poster);
        
        /*
        
        84pt font size for reference poster 
        = 84 pt and 150 dpi und A3 (42,0 cm Höhe)
        = 84 pt and 150 dpi und 16,535 inch (42*2,54)
        = 84 pt bei 2480 pt Gesamthöhe (150*16,535)
        =  x pt bei 603 px Gesamthöhe
        =  20,42 pt bei 603 px
        
        84          x
        ----   =   ----
        2480        603
        
                84 * 603
        x =    ----------
                  2480
        
        */
        
        $fontSizeRatio = $posterReferenceSizePx['height'] / $posterReferenceSizeHeightPt;

        
        $config = $poster->getConfig();
        
        $userunit['x'] = $posterReferenceSizePx['width']/$config['size']['cols'];
        $userunit['y'] = $posterReferenceSizePx['height']/$config['size']['rows'];
        
        // Get labels from poster config
        $labels = $poster->getLabels();
        if ($labels) {
            foreach($labels as $k => $label) {
            
                // Calculate the width and height of the label
                $labelWidth = $label['dim'][0] * $userunit['x'];
                $labelHeight = $label['dim'][1] * $userunit['y'];
                
                
                // Create Label image
                $im=imagecreatetruecolor($labelWidth,$labelHeight);
                
                // Load the style from the label class
                $style = $config['styles'][$label['style']];
                
                // Labelbox colors and width
                $labelStrokeColor = imagecolorclosestalpha( $im , $style['stroke']['r'], $style['stroke']['g'], $style['stroke']['b'], $style['stroke']['a']);
                $labelFillColor = imagecolorclosestalpha( $im , $style['fill']['r'], $style['fill']['g'], $style['fill']['b'], $style['fill']['a']);
                // $labelStrokeWidth = imagecolorclosestalpha( $im ->setlinewidth($style['lineWidthPt']);

                // Poster Label Box Background
                imagefilledrectangle($im, 0, 0, $labelWidth, $labelHeight, $labelFillColor);
                
                // Label textlines
                $textlines = $label['textlines'];
                if ($textlines) {
                    foreach($textlines as $k => $textline) {
                        
                        // Load the textline style from style
                        $style = $config['styles'][$textline['style']];
                        
                        $font = __DIR__.'/../Resources/views/PosterFonts/' . $style['font'];
                        
                        $size = $style['fontsize'] * $fontSizeRatio;

                        $logger->info($this->loggerDecorator("Fontsize of '".$textline['name']."': " . $size));
                        $logger->info($this->loggerDecorator("Margin_H of '".$textline['name']."': " . $style['marginh']));
                        $logger->info($this->loggerDecorator("Margin_V of '".$textline['name']."': " . $style['marginv']));
                        //$logger->info($this->loggerDecorator("Fontsize of '".$textline['name']."': " . $size));
                        //$logger->info($this->loggerDecorator("Fontsize of '".$textline['name']."': " . $size));
                        
                        $fontcolor = imagecolorclosestalpha($im, $style['fill']['r'], $style['fill']['g'], $style['fill']['b'], $style['fill']['a']);
                        
                        // calculateFontSizeToFitBox($text, $fontFile, $fontAngle, $minSize, $maxSize, $maxWidth, $maxHeight) { 
                        $ct = $this->calculateFontSizeToFitBox($textline['value'], $font, 0, 2, $size, $labelWidth-2*$style['marginh']*$userunit['x'], $labelHeight-$style['marginv']*$userunit['y']);
                        
                        // calculateTextBox($text,$fontFile,$fontSize,$fontAngle) 
                        /*
                         "left"   => abs($minX) - 1, 
                         "top"    => abs($minY) - 1, 
                         "width"  => $maxX - $minX, 
                         "height" => $maxY - $minY, 
                         "box"    => $rect
                        */
                        $tb = $this->calculateTextBox($textline['value'],$font, $ct['fontsize'],0);
                        
                        if($textline['name'] == "title") {
                            $debugFillColor = imagecolorclosestalpha( $im , 255, 0, 0, 50);
                            // imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
                            // imagefilledrectangle($im, $style['marginh']*$userunit['x'], $style['marginv']*$userunit['y'], $labelWidth-1*$style['marginh']*$userunit['x'], $style['marginv']*$userunit['y']+$tb['height'], $debugFillColor);
                            
                        }
                        if($textline['name'] == "subtitle") {
                            $debugFillColor = imagecolorclosestalpha( $im , 0, 255, 0, 50);
                            // imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
                            // imagefilledrectangle($im, $style['marginh']*$userunit['x'], $style['marginv']*$userunit['y'], $labelWidth-1*$style['marginh']*$userunit['x'], $style['marginv']*$userunit['y']+$tb['height'], $debugFillColor);
                            
                        }
                        
                        // imagettftext($im,$fc['fontsize'],0,$fc['left'],$fc['top'],$fontfill,$fontFolder.$font,$text);
                        imagettftext($im, $ct['fontsize'], 0, $style['marginh']*$userunit['x'], $style['marginv']*$userunit['y']+$tb['height'], $fontcolor, $font, $textline['value']);
                        
                    }
                }
                
                
            }
        }
        
        $imageTempFolder = $this->container->getParameter('label_public_folder');
        $webdir = $this->getRequest()->getBasePath();
        
        $imageName = $poster->getId().".png";
        imagepng($im, $imageTempFolder.$imageName);
        imagedestroy($im);
        
        $pathToLabel = "../prints/poster_label/".$imageName;
        $urlToLabel = $this->getRequest()->getUriForPath($pathToLabel);

        $url =   $this->getRequest()->getScheme()."://"
                .$this->getRequest()->headers->get('host')
                .$this->getRequest()->getBasePath()
                ."/prints/poster_label/".$imageName;
                
        return $url;
        
  
  
    }

    private function calculateTextBox($text,$fontFile,$fontSize,$fontAngle) 
    {
        /************ 
        simple function that calculates the *exact* bounding box (single pixel precision). 
        The function returns an associative array with these keys: 
        left, top:  coordinates you will pass to imagettftext 
        width, height: dimension of the image you have to create 
        *************/ 
        $rect = imagettfbbox($fontSize,$fontAngle,$fontFile,$text); 
        $minX = min(array($rect[0],$rect[2],$rect[4],$rect[6])); 
        $maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6])); 
        $minY = min(array($rect[1],$rect[3],$rect[5],$rect[7])); 
        $maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7])); 

        return array("left"   => abs($minX) - 1,
                     "top"    => abs($minY) - 1,
                     "width"  => $maxX - $minX,
                     "height" => $maxY - $minY,
                     "box"    => $rect
        ); 
    }

    private function calculateFontSizeToFitBox($text, $fontFile, $fontAngle, $minSize, $maxSize, $maxWidth, $maxHeight)
    {
        for( $fontSize = ceil($maxSize); $fontSize >= $minSize; $fontSize-- )
        {
            $textboxSize = $this->calculateTextBox($text, $fontFile, $fontSize, $fontAngle);
            $width = $textboxSize['width'];
            $height = $textboxSize['height'];
            if($width <= $maxWidth && $height <= $maxHeight)
            {
                return array(   "fontsize"  => $fontSize,
                                "width"  => $width, 
                                "height" => $height, 
                );
            }
        }        
        return false;
    }

    // Currently this function only calculates image parameters, comments to be added later
    protected function generateJSONTileObject($posterObj, $tileWidth, $tileHeight, $bbWidth, $bbHeight)
    {

      if (!defined("CM_INCH_RATIO")) {
        define("CM_INCH_RATIO", 2.54);
      }

      // Prepare action services
      $logger     =   $this->get('logger');

      // Configuration which image to use in HTML preview
      $htmlImageSize = $this->container->getParameter('poster_photo_facebook_preview_size');
      $images = $posterObj->getPhoto()->getImages();
      
      // Use local image if available, else use preview size image URL from facebook
      if($localImage = $posterObj->getPhoto()->getLocalPreviewImage()) {
        $image['src'] = $localImage;
      }
      else {
        $image['src'] = $images[$htmlImageSize]['source'];
      }

      $imageOffset = unserialize($posterObj->getPhotoOffset());
      $image['o'] = $posterObj->getPhotoOrientation();
      $fittedImageDimension = $this->getImageDimensionFittingIntoTile($images[$htmlImageSize]['width'], $images[$htmlImageSize]['height'], $tileWidth, $tileHeight);
      $image['w'] = $fittedImageDimension['w'];
      $image['h'] = $fittedImageDimension['h'];
      $image['offsetX'] = $bbWidth  * $imageOffset['x'];
      $image['offsetY'] = $bbHeight * $imageOffset['y'];

      $obj = $image;

      return $obj;

    }
}

    
