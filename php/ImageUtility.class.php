<?php
	
	class ImageUtility
	{
		private $image_src;
		
		function __construct($image_src)
		{
			$this->image_src = $image_src;
		}
		
		public function resizeAndSave($name,$path,$width,$height)
		{
			$image = new Imagick($this->image_src);
			
			// If 0 is provided as a width or height parameter,
			// aspect ratio is maintained
			$image->thumbnailImage($width, $height);
	
			file_put_contents($path.$name,$image);
		}
		public function resizeToScaleWithDimension($name,$path,$dimension)
		{
			$image = new Imagick($this->image_src);
			$width = $image->getImageWidth();
			$height = $image->getImageHeight();
			
			if($width > $height)
			{
				$image->thumbnailImage($dimension, 0);
			}
			else
			{
				$image->thumbnailImage(0, $dimension);
			}
			
			file_put_contents($path.$name,$image);
		}
		public function cropAndSave($name,$path,$width,$height)
		{
			$image = new Imagick($this->image_src);

			$image->cropThumbnailImage($width,$height);

			file_put_contents($path.$name,$image);
		}

        public function cropAndSave2($width,$height)
        {
            $image = new Imagick($this->image_src);

            $image->cropThumbnailImage($width,$height);

            file_put_contents($this->image_src,$image);
        }
	}
?>