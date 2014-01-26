<?php

class CImage {

    private $src = null; 
    private $verbose = null; 
    public $saveAs  = null; 
    public $quality = null; 
    private $ignoreCache = null;
    public $width = null; 
    public $height = null; 
    public $newWidth = null; 
    public $newHeight = null; 
    public $maxWidth = 700; 
    public $maxHeight  = 530; 
    public $cropToFit = null; 
    public $sharpen = null;     
    public $pathToImage = null; 
    private $errorMessage = null; 
    private $cacheFileName = null; 
    private $image = null; 
    public $fileExtension = null; 
    public $filesize = null; 
     

    public function __construct() { 
        $this->src = isset($_GET['src']) ? $_GET['src'] : null;
		//var_dump( $_GET['src']);
        $this->verbose = isset($_GET['verbose']) ? true : null; 
        $this->saveAs = isset($_GET['save-as']) ? $_GET['save-as']  : null; 
        $this->quality = isset($_GET['quality']) ? $_GET['quality']  : 60; 
        $this->ignoreCache = isset($_GET['no-cache']) ? true  : null; 
        $this->newWidth = isset($_GET['width']) ? $_GET['width']    : null; 
        $this->newHeight = isset($_GET['height']) ? $_GET['height']   : null; 
        $this->cropToFit = isset($_GET['crop-to-fit']) ? true  : null; 
        $this->sharpen = isset($_GET['sharpen']) ? true  : null; 
        $this->pathToImage = realpath(IMG_PATH . $this->src); 
         
        $this->validateIncomingArguments(); 
        $this->imageInformation(); 
        $this->createImageCache();   
        $this->checkCache(); 
        $this->openImage();  
        $this->resizeImage();
        $this->cropImage();
        $this->saveImage();
        $this->outputImage($this->pathToImage); 
    } 
     
    private function validateIncomingArguments(){ 

        is_dir(IMG_PATH) or $this->errorMessage('The image dir is not a valid directory.'); 
        is_writable(CACHE_PATH) or $this->errorMessage('The cache dir is not a writable directory.'); 
         
        isset($this->src) or $this->errorMessage("Must set src-attribute.<br>Try this link: <a href='?src=TripleGEM.png&amp;verbose=true'>?src=TripleGEM.png&amp;verbose=true</a>"); 
        preg_match('#^[a-z0-9A-Z-_\.\/]+$#', $this->src) and !empty($this->src) or $this->errorMessage('Filename contains invalid characters or is empty.'); 
        substr_compare(IMG_PATH, $this->pathToImage, 0, strlen(IMG_PATH)) == 0 or $this->errorMessage('Security constraint: Source image is not directly below the directory IMG_PATH.'); 
         
        //is_null returns true if var is null, if not null do expression. 
        is_null($this->saveAs) or in_array($this->saveAs, array('png', 'jpg', 'jpeg', 'gif')) or $this->errorMessage('Not a valid extension to save image as'); 
        is_null($this->quality) or (is_numeric($this->quality) and $this->quality > 0 and $this->quality <= 100) or $this->errorMessage('Quality out of range'); 
        is_null($this->newWidth) or (is_numeric($this->newWidth) and $this->newWidth > 0 and $this->newWidth <= $this->maxWidth) or $this->errorMessage('Width out of range'); 
        is_null($this->newHeight ) or (is_numeric($this->newHeight) and $this->newHeight > 0 and $this->newHeight <= $this->maxHeight) or $this->errorMessage('Height out of range'); 
        is_null($this->cropToFit) or ($this->cropToFit and $this->newWidth and $this->newHeight) or $this->errorMessage('Crop to fit needs both width and height to work'); 
    } 
     
    function errorMessage($message) {
      header("Status: 404 Not Found");
      die('img.php says 404 - ' . htmlentities($message));
    }

    private function verbose($message) { 
        echo "<p>" . htmlentities($message) . "</p>"; 
    } 
     
           
    private function imageInformation(){ 

        $imgInfo = list($this->width, $this->height, $type, $attr) = getimagesize($this->pathToImage); 
        !empty($imgInfo) or errorMessage("The file doesn't seem to be an image."); 
        $mime = $imgInfo['mime']; 

        if($this->verbose) { 
            $this->filesize = filesize($this->pathToImage); 
            $this->verbose("Image file: {$this->pathToImage}"); 
            $this->verbose("Image information: " . print_r($imgInfo, true)); 
            $this->verbose("Image width x height (type): {$this->width} x {$this->height} ({$type})."); 
            $this->verbose("Image file size: {$this->filesize} bytes."); 
            $this->verbose("Image mime type: {$mime}."); 
        } 
    } 

    private function createImageCache()    {         
         
        $parts          = pathinfo($this->src); 
        $this->fileExtension  = $parts['extension']; 
        $this->saveAs         = is_null($this->saveAs) ? $this->fileExtension : $this->saveAs; 
        $quality_       = is_null($this->quality) ? null : "_q{$this->quality}"; 
        $cropToFit_     = is_null($this->cropToFit) ? null : "_cf"; 
        $sharpen_       = is_null($this->sharpen) ? null : "_s"; 
        $dirName        = preg_replace('/\//', '-', dirname($this->src)); 
        $this->cacheFileName = CACHE_PATH . "-{$dirName}-{$parts['filename']}_{$this->newWidth}_{$this->newHeight}{$quality_}{$cropToFit_}{$sharpen_}.{$this->saveAs}"; 
        $this->cacheFileName = preg_replace('/^a-zA-Z0-9\.-_/', '', $this->cacheFileName); 

        if($this->verbose) { $this->verbose("Cache file is: {$this->cacheFileName}"); } 
    } 
     
    private function checkCache()    { 
         
        $imageModifiedTime = filemtime($this->pathToImage); 
        $cacheModifiedTime = is_file($this->cacheFileName) ? filemtime($this->cacheFileName) : null; 
          
        // If cached image is valid, output it. 
        if(!$this->ignoreCache && is_file($this->cacheFileName) && $imageModifiedTime < $cacheModifiedTime) { 
            if($this->verbose) { $this->verbose("Cache file is valid, output it."); } 
            $this->outputImage($this->cacheFileName, $this->verbose); 
        } 
          
        if($this->verbose) { $this->verbose("Cache is not valid, process image and create a cached version of it."); } 
    } 
     

    private function cropImage(){ 
        if($this->cropToFit && $this->newWidth && $this->newHeight) { 
            $targetRatio = $this->newWidth / $this->newHeight; 
            $cropWidth   = $targetRatio > $aspectRatio ? $this->width : round($this->height * $targetRatio); 
            $cropHeight  = $targetRatio > $aspectRatio ? round($this->width  / $targetRatio) : $this->height; 
            if($this->verbose) { $this->verbose("Crop to fit into box of {$this->newWidth}x{$this->newHeight}. Cropping dimensions: {$cropWidth}x{$cropHeight}."); } 
        } 

        if($this->cropToFit) { 
            if($this->verbose) { $this->verbose("Resizing, crop to fit."); } 
            $cropX = round(($this->width - $cropWidth) / 2);   
            $cropY = round(($this->height - $cropHeight) / 2);     
            $imageResized = imagecreatetruecolor($this->newWidth, $this->newHeight); 
            imagecopyresampled($imageResized, $this->image, 0, 0, $cropX, $cropY, $this->newWidth, $this->newHeight, $cropWidth, $cropHeight); 
            $this->image = $imageResized; 
            $this->width = $this->newWidth; 
            $this->height = $this->newHeight; 
        } 
    } 
     
    private function resizeImage()    { 
        $aspectRatio = $this->width / $this->height; 
        if($this->newWidth && !$this->newHeight) { 
            $this->newHeight = round($this->newWidth / $aspectRatio); 
            if($this->verbose) { $this->verbose("New width is known {$this->newWidth}, height is calculated to {$this->newHeight}."); } 
        } 
        else if(!$this->newWidth && $this->newHeight) { 
            $this->newWidth = round($this->newHeight * $aspectRatio); 
            if($this->verbose) { $this->verbose("New height is known {$this->newHeight}, width is calculated to {$this->newWidth}."); } 
        } 
        else if($this->newWidth && $this->newHeight) { 
            $ratioWidth  = $this->width  / $this->newWidth; 
            $ratioHeight = $this->height / $this->newHeight; 
            $ratio = ($ratioWidth > $ratioHeight) ? $ratioWidth : $ratioHeight; 
            $this->newWidth  = round($this->width  / $ratio); 
            $this->newHeight = round($this->height / $ratio); 
            if($this->verbose) { $this->verbose("New width & height is requested, keeping aspect ratio results in {$this->newWidth}x{$this->newHeight}."); } 
        } 
        else { 
            $this->newWidth = $this->width; 
            $this->newHeight = $this->height; 
            if($this->verbose) { $this->verbose("Keeping original width & heigth."); } 
        } 

        if(!($this->newWidth == $this->width && $this->newHeight == $this->height)) { 
            $imageResized = imagecreatetruecolor($this->newWidth, $this->newHeight); 
            imagecopyresampled($imageResized, $this->image, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height); 
            $this->image  = $imageResized; 
            $this->width  = $this->newWidth; 
            $this->height = $this->newHeight; 
        } 
    } 
     
    private function sharpenImage() { 
        $matrix = array( 
            array(-1,-1,-1,), 
            array(-1,16,-1,), 
            array(-1,-1,-1,) 
        ); 
        $divisor = 8; 
        $offset = 0; 
        imageconvolution($this->image, $matrix, $divisor, $offset); 
         
        return $this->image; 
    } 

    private function openImage()    { 
        if($this->verbose) { $this->verbose("File extension is: {$this->fileExtension}"); } 

        switch($this->fileExtension) {   
            case 'jpg': 
            case 'jpeg':  
                $this->image = imagecreatefromjpeg($this->pathToImage); 
                if($this->verbose) { $this->verbose("Opened the image as a JPEG image."); } 
                break;   
             
            case 'png':   
                $this->image = imagecreatefrompng($this->pathToImage);  
                if($this->verbose) { $this->verbose("Opened the image as a PNG image."); } 
                break;   

           case 'gif':   
                $this->image = imagecreatefromgif($this->pathToImage);  
                if($this->verbose) { $this->verbose("Opened the image as a GIF image."); } 
                break;  

            default: $this->errorMessage('No support for this file extension.'); 
        } 
    } 
         
    private function saveImage()    { 
        switch($this->saveAs) { 
            case 'jpeg': 
            case 'jpg': 
                if($this->verbose) { $this->verbose("Saving image as JPEG to cache using quality = {$this->quality}."); } 
                imagejpeg($this->image, $this->cacheFileName, $this->quality); 
            break;   

            case 'png':   
                if($this->verbose) { $this->verbose("Saving image as PNG to cache."); } 
                imagepng($this->image, $this->cacheFileName);   
            break;  

            case 'gif':   
                if($this->verbose) { $this->verbose("Saving image as GIF to cache."); } 
                imagegif($this->image, $this->cacheFileName);   
            break;   

            default: 
                $this->errorMessage('No support to save as this file extension.'); 
            break; 
        } 

        if($this->verbose) {  
            clearstatcache(); 
            $cacheFilesize = filesize($this->cacheFileName); 
            $this->verbose("File size of cached file: {$cacheFilesize} bytes.");  
            $this->verbose("Cache file has a file size of " . round($cacheFilesize/$this->filesize*100) . "% of the original size."); 
        } 
    } 
     

    private function outputImage($file) { 

        $info = getimagesize($file); 
        !empty($info) or $this->errorMessage("The file doesn't seem to be an image."); 
        $mime   = $info['mime']; 
        $lastModified = filemtime($file);   
     
        $gmdate = gmdate("D, d M Y H:i:s", $lastModified); 

        if($this->verbose) { 
          $query = array(); 
          parse_str($_SERVER['QUERY_STRING'], $query); 
          unset($query['verbose']); 
          $url = '?' . http_build_query($query); 

        echo <<<EOD
        <html lang='en'>
        <meta charset='UTF-8'/>
        <title>img.php verbose mode</title>
        <h1>Verbose mode</h1>
        <p><a href=$url><code>$url</code></a><br>
        <img src='{$url}' /></p>
EOD;

            $this->verbose("Memory peak: " . round(memory_get_peak_usage() /1024/1024) . "M"); 
            $this->verbose("Memory limit: " . ini_get('memory_limit')); 
            $this->verbose("Time is {$gmdate} GMT."); 
        } 

        if(!$this->verbose) header('Last-Modified: ' . $gmdate . ' GMT'); 
        if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastModified){ 
            if($this->verbose) { $this->verbose("Would send header 304 Not Modified, but its $this->verbose mode."); exit; } 
            header('HTTP/1.0 304 Not Modified'); 
        } else {   
            if($this->verbose) { $this->verbose("Would send header to deliver image with modified time: {$gmdate} GMT, but its $this->verbose mode."); exit; } 
            header('Content-type: ' . $mime);   
            readfile($file); 
        } 
        exit; 
    } 
}