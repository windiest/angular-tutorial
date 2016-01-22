// For original FULL CODE COMMENTS grab the original lightbox source: http://www.huddletogether.com/projects/lightbox2/releases/lightbox2.03.3.zip
//	Lightbox v2.03.3 by Lokesh Dhakar
//	http://huddletogether.com/projects/lightbox2/
//	Licensed under the Creative Commons Attribution 2.5 License
// -----------------------------------------------------------------------------------
//	Configuration
var overlayOpacity = 0.8;	// controls transparency of shadow overlay
var animate = true;			// toggles resizing animations
var resizeSpeed = 9;		// controls the speed of the image resizing animations (1=slowest and 10=fastest)
var borderSize = 10;		//if you adjust the padding in the CSS, you will need to update this variable
// -----------------------------------------------------------------------------------
//	Global Variables
var imageArray = new Array;
var activeImage;
if(animate == true){
	overlayDuration = 0.2;	// shadow fade in/out duration
	if(resizeSpeed > 10){ resizeSpeed = 10;}
	if(resizeSpeed < 1){ resizeSpeed = 1;}
	resizeDuration = (11 - resizeSpeed) * 0.15;
} else { 
	overlayDuration = 0;
	resizeDuration = 0;
}
// -----------------------------------------------------------------------------------
//	Additional methods for Element
Object.extend(Element, {
	getWidth: function(element) {
	   	element = $(element);
	   	return element.offsetWidth; 
	},
	setWidth: function(element,w) {
	   	element = $(element);
    	element.style.width = w +"px";
	},
	setHeight: function(element,h) {
   		element = $(element);
    	element.style.height = h +"px";
	},
	setTop: function(element,t) {
	   	element = $(element);
    	element.style.top = t +"px";
	},
	setLeft: function(element,l) {
	   	element = $(element);
    	element.style.left = l +"px";
	},
	setSrc: function(element,src) {
    	element = $(element);
    	element.src = src; 
	},
	setHref: function(element,href) {
    	element = $(element);
    	element.href = href; 
	},
	setInnerHTML: function(element,content) {
		element = $(element);
		element.innerHTML = content;
	}
});
// -----------------------------------------------------------------------------------
//	Extending built-in Array object
//	- array.removeDuplicates()
//	- array.empty()
Array.prototype.removeDuplicates = function () {
    for(i = 0; i < this.length; i++){
        for(j = this.length-1; j>i; j--){        
            if(this[i][0] == this[j][0]){
                this.splice(j,1);
            }
        }
    }
}
// -----------------------------------------------------------------------------------
Array.prototype.empty = function () {
	for(i = 0; i <= this.length; i++){
		this.shift();
	}
}
// -----------------------------------------------------------------------------------
var Lightbox = Class.create();
Lightbox.prototype = {
	// initialize()
	// Constructor runs on completion of the DOM loading. Calls updateImageList and then
	// the function inserts html at the bottom of the page which is used to display the shadow 
	// overlay and the image container.
	initialize: function() {	
		
		this.updateImageList();
		var objBody = document.getElementsByTagName("body").item(0);
		var objOverlay = document.createElement("div");
		objOverlay.setAttribute('id','stimuli_overlay');
		objOverlay.style.display = 'none';
		objOverlay.onclick = function() { myLightbox.end(); }
		objBody.appendChild(objOverlay);
		var objLightbox = document.createElement("div");
		objLightbox.setAttribute('id','stimuli_lightbox');
		objLightbox.style.display = 'none';
		objLightbox.onclick = function(e) {	// close Lightbox if user clicks shadow overlay
			if (!e) var e = window.event;
			var clickObj = Event.element(e).id;
			if ( clickObj == 'stimuli_lightbox') {
				myLightbox.end();
			}
		};
		objBody.appendChild(objLightbox);
		var objOuterImageContainer = document.createElement("div");
		objOuterImageContainer.setAttribute('id','stimuli_outerImageContainer');
		objLightbox.appendChild(objOuterImageContainer);
		// When Lightbox starts it will resize itself from 250 by 250 to the current image dimension.
		// If animations are turned off, it will be hidden as to prevent a flicker of a
		// white 250 by 250 box.
		if(animate){
			Element.setWidth('stimuli_outerImageContainer', 250);
			Element.setHeight('stimuli_outerImageContainer', 250);			
		} else {
			Element.setWidth('stimuli_outerImageContainer', 1);
			Element.setHeight('stimuli_outerImageContainer', 1);			
		}
		var objImageContainer = document.createElement("div");
		objImageContainer.setAttribute('id','stimuli_imageContainer');
		objOuterImageContainer.appendChild(objImageContainer);
	
		var objLightboxImage = document.createElement("img");
		objLightboxImage.setAttribute('id','stimuli_lightboxImage');
		objImageContainer.appendChild(objLightboxImage);
	
		var objHoverNav = document.createElement("div");
		objHoverNav.setAttribute('id','stimuli_hoverNav');
		objImageContainer.appendChild(objHoverNav);
	
		var objPrevLink = document.createElement("a");
		objPrevLink.setAttribute('id','stimuli_prevLink');
		objPrevLink.setAttribute('href','#');
		objHoverNav.appendChild(objPrevLink);
		
		var objNextLink = document.createElement("a");
		objNextLink.setAttribute('id','stimuli_nextLink');
		objNextLink.setAttribute('href','#');
		objHoverNav.appendChild(objNextLink);
	
		var objLoading = document.createElement("div");
		objLoading.setAttribute('id','stimuli_loading');
		objImageContainer.appendChild(objLoading);
	
		var objLoadingLink = document.createElement("a");
		objLoadingLink.setAttribute('id','stimuli_loadingLink');
		objLoadingLink.setAttribute('href','#');
		objLoadingLink.onclick = function() { myLightbox.end(); return false; }
		objLoading.appendChild(objLoadingLink);

		var objImageDataContainer = document.createElement("div");
		objImageDataContainer.setAttribute('id','stimuli_imageDataContainer');
		objLightbox.appendChild(objImageDataContainer);
		var objImageData = document.createElement("div");
		objImageData.setAttribute('id','stimuli_imageData');
		objImageDataContainer.appendChild(objImageData);
	
		var objImageDetails = document.createElement("div");
		objImageDetails.setAttribute('id','stimuli_imageDetails');
		objImageData.appendChild(objImageDetails);
	
		var objCaption = document.createElement("span");
		objCaption.setAttribute('id','stimuli_caption');
		objImageDetails.appendChild(objCaption);
	
		var objNumberDisplay = document.createElement("span");
		objNumberDisplay.setAttribute('id','stimuli_numberDisplay');
		objImageDetails.appendChild(objNumberDisplay);
		
		var objBottomNav = document.createElement("div");
		objBottomNav.setAttribute('id','stimuli_bottomNav');
		objImageData.appendChild(objBottomNav);
	
		var objBottomNavCloseLink = document.createElement("a");
		objBottomNavCloseLink.setAttribute('id','stimuli_bottomNavClose');
		objBottomNavCloseLink.setAttribute('href','#');
		objBottomNavCloseLink.onclick = function() { myLightbox.end(); return false; }
		objBottomNav.appendChild(objBottomNavCloseLink);
	},
	// updateImageList()
	// Loops through anchor tags looking for 'lightbox' references and applies onclick
	// events to appropriate links. You can rerun after dynamically adding images w/ajax.
	updateImageList: function() {	
		if (!document.getElementsByTagName){ return; }
		var anchors = document.getElementsByTagName('a');
		var areas = document.getElementsByTagName('area');
		// loop through all anchor tags
		for (var i=0; i<anchors.length; i++){
			var anchor = anchors[i];
			var relAttribute = String(anchor.getAttribute('rel'));
			// use the string.match() method to catch 'lightbox' references in the rel attribute
			if (anchor.getAttribute('href') && (relAttribute.toLowerCase().match('lightbox'))){
				anchor.onclick = function () {myLightbox.start(this); return false;}
			}
		}
		// loop through all area tags
		// todo: combine anchor & area tag loops
		for (var i=0; i< areas.length; i++){
			var area = areas[i];
			var relAttribute = String(area.getAttribute('rel'));
			// use the string.match() method to catch 'lightbox' references in the rel attribute
			if (area.getAttribute('href') && (relAttribute.toLowerCase().match('lightbox'))){
				area.onclick = function () {myLightbox.start(this); return false;}
			}
		}
	},
	//	start()
	//	Display overlay and lightbox. If image is part of a set, add siblings to imageArray.
	start: function(imageLink) {	
		hideSelectBoxes();
		hideFlash();
		// stretch overlay to fill page and fade in
		var arrayPageSize = getPageSize();
		Element.setWidth('stimuli_overlay', arrayPageSize[0]);
		Element.setHeight('stimuli_overlay', arrayPageSize[1]);
		new Effect.Appear('stimuli_overlay', { duration: overlayDuration, from: 0.0, to: overlayOpacity });
		imageArray = [];
		imageNum = 0;		
		if (!document.getElementsByTagName){ return; }
		var anchors = document.getElementsByTagName( imageLink.tagName);
		var stimuli_image_title = "";
		// if image is NOT part of a set... ie not lightbox[someset]
		if((imageLink.getAttribute('rel') == 'lightbox')){
			// check for title-less links, and grab image title if needed
			stimuli_image_title = "";
			var possibleLightboxImageTitles = [imageLink.getAttribute('title'), imageLink.childNodes[0]['title'], imageLink.childNodes[0]['alt'], " "];
			var possible_Int = 0;
			while (stimuli_image_title == ("")) {
				stimuli_image_title = possibleLightboxImageTitles[possible_Int];
				possible_Int++;
			}
			// add single image to imageArray
			imageArray.push(new Array(imageLink.getAttribute('href'), stimuli_image_title));
		} else {
		// if image is part of a set... ie lightbox[someset]
			// loop through anchors, find other images in set, and add them to imageArray
			for (var i=0; i<anchors.length; i++){
				var anchor = anchors[i];
				if (anchor.getAttribute('href') && (anchor.getAttribute('rel') == imageLink.getAttribute('rel'))){
					// check for title-less links, and grab image title if needed
					stimuli_image_title = "";
					var possibleLightboxImageTitles = [ anchor['title'], anchor.childNodes[0]['title'], anchor.childNodes[0]['alt'], " " ];
					var possible_Int = 0;
					while (stimuli_image_title == ("")) {
						stimuli_image_title = possibleLightboxImageTitles[possible_Int];
						possible_Int++;
					}
					imageArray.push(new Array(anchor.getAttribute('href'), stimuli_image_title));
				}
			}
			imageArray.removeDuplicates();
			while(imageArray[imageNum][0] != imageLink.getAttribute('href')) { imageNum++;}
		}
		// calculate top and left offset for the lightbox 
		var arrayPageScroll = getPageScroll();
		var lightboxTop = arrayPageScroll[1] + (arrayPageSize[3] / 10);
		var lightboxLeft = arrayPageScroll[0];
		Element.setTop('stimuli_lightbox', lightboxTop);
		Element.setLeft('stimuli_lightbox', lightboxLeft);
		Element.show('stimuli_lightbox');
		this.changeImage(imageNum);
	},
	//	changeImage()
	//	Hide most elements and preload image in preparation for resizing image container.
	changeImage: function(imageNum) {	
		activeImage = imageNum;	// update global var
		// hide elements during transition
		if(animate){ Element.show('stimuli_loading');}
		Element.hide('stimuli_lightboxImage');
		Element.hide('stimuli_hoverNav');
		Element.hide('stimuli_prevLink');
		Element.hide('stimuli_nextLink');
		Element.hide('stimuli_imageDataContainer');
		Element.hide('stimuli_numberDisplay');		
		imgPreloader = new Image();
		// once image is preloaded, resize image container
		imgPreloader.onload=function(){
			// Shrink larger images horizontally and/or vertically to fit screen without scrolling:
			if(arrayPageSize[0]<imgPreloader.width) {
			    imgPreloader.height=(imgPreloader.height*(arrayPageSize[0]-2*borderSize)/imgPreloader.width);
			    imgPreloader.width=(arrayPageSize[0]-2*borderSize);
			}
			if(arrayPageSize[3]<imgPreloader.height) { //15 is a number that 'just works'
			    imgPreloader.width=(imgPreloader.width*(arrayPageSize[3]-15*borderSize)/imgPreloader.height);
			    imgPreloader.height=(arrayPageSize[3]-15*borderSize);
			}
			Element.setSrc('stimuli_lightboxImage', imageArray[activeImage][0]);
			Element.setWidth('stimuli_lightboxImage', imgPreloader.width);
			Element.setHeight('stimuli_lightboxImage', imgPreloader.height);
			myLightbox.resizeImageContainer(imgPreloader.width, imgPreloader.height);
			imgPreloader.onload=function(){};	//	clear onLoad, IE behaves erratically with animated gifs otherwise 
		}
		imgPreloader.src = imageArray[activeImage][0];
	},
	//	resizeImageContainer()
	resizeImageContainer: function( imgWidth, imgHeight) {
		// get curren width and height
		this.widthCurrent = Element.getWidth('stimuli_outerImageContainer');
		this.heightCurrent = Element.getHeight('stimuli_outerImageContainer');
		// get new width and height
		var widthNew = (imgWidth  + (borderSize * 2));
		var heightNew = (imgHeight  + (borderSize * 2));
		// scalars based on change from old to new
		this.xScale = ( widthNew / this.widthCurrent) * 100;
		this.yScale = ( heightNew / this.heightCurrent) * 100;
		// calculate size difference between new and old image, and resize if necessary
		wDiff = this.widthCurrent - widthNew;
		hDiff = this.heightCurrent - heightNew;
		if(!( hDiff == 0)){ new Effect.Scale('stimuli_outerImageContainer', this.yScale, {scaleX: false, duration: resizeDuration, queue: 'front'}); }
		if(!( wDiff == 0)){ new Effect.Scale('stimuli_outerImageContainer', this.xScale, {scaleY: false, delay: resizeDuration, duration: resizeDuration}); }
		// if new and old image are same size and no scaling transition is necessary, 
		// do a quick stimuli_pause to prevent image flicker.
		if((hDiff == 0) && (wDiff == 0)){
			if (navigator.appVersion.indexOf("MSIE")!=-1){ stimuli_pause(250); } else { stimuli_pause(100);} 
		}
		Element.setHeight('stimuli_prevLink', imgHeight);
		Element.setHeight('stimuli_nextLink', imgHeight);
		Element.setWidth( 'stimuli_imageDataContainer', widthNew);
		this.showImage();
	},
	//	showImage()
	//	Display image and begin preloading neighbors.
	showImage: function(){
		Element.hide('stimuli_loading');
		new Effect.Appear('stimuli_lightboxImage', { duration: resizeDuration, queue: 'end', afterFinish: function(){	myLightbox.updateDetails(); } });
		this.preloadNeighborImages();
	},
	//	updateDetails()
	//	Display caption, image number, and bottom nav.
	updateDetails: function() {
		// if caption is not null
		if(imageArray[activeImage][1]){
			Element.show('stimuli_caption');
			Element.setInnerHTML( 'stimuli_caption', imageArray[activeImage][1]);
		}
		// if image is part of set display 'Image x of x' 
		if(imageArray.length > 1){
			Element.show('stimuli_numberDisplay');
			Element.setInnerHTML( 'stimuli_numberDisplay', "Image " + eval(activeImage + 1) + " of " + imageArray.length);
		}
		new Effect.Parallel(
			[ new Effect.SlideDown( 'stimuli_imageDataContainer', { sync: true, duration: resizeDuration, from: 0.0, to: 1.0 }), 
			  new Effect.Appear('stimuli_imageDataContainer', { sync: true, duration: resizeDuration }) ], 
			{ duration: resizeDuration, afterFinish: function() {
				// update overlay size and update nav
				var arrayPageSize = getPageSize();
				Element.setHeight('stimuli_overlay', arrayPageSize[1]);
				myLightbox.updateNav();
				}
			} 
		);
	},
	//	updateNav()
	//	Display appropriate previous and next hover navigation.
	updateNav: function() {
		Element.show('stimuli_hoverNav');				
		// if not first image in set, display prev image button
		if(activeImage != 0){
			Element.show('stimuli_prevLink');
			document.getElementById('stimuli_prevLink').onclick = function() {
				myLightbox.changeImage(activeImage - 1); return false;
			}
		}
		// if not last image in set, display next image button
		if(activeImage != (imageArray.length - 1)){
			Element.show('stimuli_nextLink');
			document.getElementById('stimuli_nextLink').onclick = function() {
				myLightbox.changeImage(activeImage + 1); return false;
			}
		}
		this.enableKeyboardNav();
	},
	//	enableKeyboardNav()
	enableKeyboardNav: function() {
		document.onkeydown = this.keyboardAction; 
	},
	//	disableKeyboardNav()
	disableKeyboardNav: function() {
		document.onkeydown = '';
	},
	//	keyboardAction()
	keyboardAction: function(e) {
		if (e == null) { // ie
			keycode = event.keyCode;
			escapeKey = 27;
		} else { // mozilla
			keycode = e.keyCode;
			escapeKey = e.DOM_VK_ESCAPE;
		}
		key = String.fromCharCode(keycode).toLowerCase();
		if((key == 'x') || (key == 'o') || (key == 'c') || (keycode == escapeKey)){	// close lightbox
			myLightbox.end();
		} else if((key == 'p') || (keycode == 37)){	// display previous image
			if(activeImage != 0){
				myLightbox.disableKeyboardNav();
				myLightbox.changeImage(activeImage - 1);
			}
		} else if((key == 'n') || (keycode == 39)){	// display next image
			if(activeImage != (imageArray.length - 1)){
				myLightbox.disableKeyboardNav();
				myLightbox.changeImage(activeImage + 1);
			}
		}
	},
	//	preloadNeighborImages()
	//	Preload previous and next images.
	preloadNeighborImages: function(){
		if((imageArray.length - 1) > activeImage){
			preloadNextImage = new Image();
			preloadNextImage.src = imageArray[activeImage + 1][0];
		}
		if(activeImage > 0){
			preloadPrevImage = new Image();
			preloadPrevImage.src = imageArray[activeImage - 1][0];
		}
	},
	//	end()
	end: function() {
		this.disableKeyboardNav();
		Element.hide('stimuli_lightbox');
		new Effect.Fade('stimuli_overlay', { duration: overlayDuration});
		showSelectBoxes();
		showFlash();
	}
}
// -----------------------------------------------------------------------------------
// getPageScroll()
function getPageScroll(){
	var xScroll, yScroll;
	if (self.pageYOffset) {
		yScroll = self.pageYOffset;
		xScroll = self.pageXOffset;
	} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
		yScroll = document.documentElement.scrollTop;
		xScroll = document.documentElement.scrollLeft;
	} else if (document.body) {// all other Explorers
		yScroll = document.body.scrollTop;
		xScroll = document.body.scrollLeft;	
	}
	arrayPageScroll = new Array(xScroll,yScroll) 
	return arrayPageScroll;
}
// -----------------------------------------------------------------------------------
// getPageSize()
function getPageSize(){
	var xScroll, yScroll;
	if (window.innerHeight && window.scrollMaxY) {	
		xScroll = window.innerWidth + window.scrollMaxX;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	var windowWidth, windowHeight;
	if (self.innerHeight) {	// all except Explorer
		if(document.documentElement.clientWidth){
			windowWidth = document.documentElement.clientWidth; 
		} else {
			windowWidth = self.innerWidth;
		}
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}
	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else { 
		pageHeight = yScroll;
	}
	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){	
		pageWidth = xScroll;		
	} else {
		pageWidth = windowWidth;
	}
	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight) 
	return arrayPageSize;
}
// -----------------------------------------------------------------------------------
// getKey(key)
function getKey(e){
	if (e == null) { // ie
		keycode = event.keyCode;
	} else { // mozilla
		keycode = e.which;
	}
	key = String.fromCharCode(keycode).toLowerCase();
	if(key == 'x'){
	}
}
// -----------------------------------------------------------------------------------
// listenKey()
function listenKey () {	document.onkeypress = getKey; }
// ---------------------------------------------------
function showSelectBoxes(){
	var selects = document.getElementsByTagName("select");
	for (i = 0; i != selects.length; i++) {
		selects[i].style.visibility = "visible";
	}
}
// ---------------------------------------------------
function hideSelectBoxes(){
	var selects = document.getElementsByTagName("select");
	for (i = 0; i != selects.length; i++) {
		selects[i].style.visibility = "hidden";
	}
}
// ---------------------------------------------------
function showFlash(){
	var flashObjects = document.getElementsByTagName("object");
	for (i = 0; i < flashObjects.length; i++) {
		flashObjects[i].style.visibility = "visible";
	}
	var flashEmbeds = document.getElementsByTagName("embed");
	for (i = 0; i < flashEmbeds.length; i++) {
		flashEmbeds[i].style.visibility = "visible";
	}
}
// ---------------------------------------------------
function hideFlash(){
	var flashObjects = document.getElementsByTagName("object");
	for (i = 0; i < flashObjects.length; i++) {
		flashObjects[i].style.visibility = "hidden";
	}
	var flashEmbeds = document.getElementsByTagName("embed");
	for (i = 0; i < flashEmbeds.length; i++) {
		flashEmbeds[i].style.visibility = "hidden";
	}
}
// ---------------------------------------------------
function stimuli_pause(ms){
	var date = new Date();
	curDate = null;
	do{var curDate = new Date();}
	while( curDate - date < ms);
}
// ---------------------------------------------------
function initLightbox() { myLightbox = new Lightbox(); }
Event.observe(window, 'load', initLightbox, false);