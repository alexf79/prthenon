<?php
class UploadedImage
{
	var $maxsize = 1048576;
	var $uploaddir;
	var $file = array();
	var $newfile;
	var $maxwidth;
	var $maxheight;
	var $allowtypes = array("image/jpg","image/jpeg","image/pjpeg","image/gif","image/png");
	var $deniedtypes = array("image/bmp");
	var $relscale = false;
	var $scale = null;
	var $ErrorMsg;
	var $final;
	var $jpegquality = 100;
	var $pictype;

	function upload_file()
	{
		if ( !isset( $this->file ) || is_null( $this->file['tmp_name'] ) || $this->file['name'] == '' )
		{
			$this->ErrorMsg = "File Not Uploaded"; 
			return (false);
		}
		
		if( $this->file['size'] > $this->maxsize )
		{
			$this->ErrorMsg = "Exceeds MaxSize of $this->maxsize bytes";
			return (false);
		}
		
/*		if ((   count($this->allowtypes) > 0 && !in_array( $this->file['type'], $this->allowtypes )) 
		   ||(	count($this->deniedtypes) > 0 && in_array( $this->file['type'], $this->deniedtypes ))){ //Check Type
		   
			$this->ErrorMsg = "File Type '.".file_extension($this->file['name'])." -- {$this->file['type']}' not allowed."; 
			return (false);
			
		}*/
			
		if( !$this->newfile ) $this->newfile = substr( basename($this->file['name']) , 0 , strrpos($this->file['name'], '.') );
		
		$uploaddirtemp = upload_dir($this->uploaddir);
		
		if($this->transfer == 'Copy')
		{
			copy( $this->file['tmp_name'] , $uploaddirtemp.$this->newfile.".".file_extension( $this->file['name'] ) );
		}
		if($this->transfer == 'Move')
		{
			move_uploaded_file( $this->file['tmp_name'] , $uploaddirtemp.$this->newfile.".".file_extension( $this->file['name'] ) );
		}
		
		chmod($uploaddirtemp.$this->newfile.".".file_extension( $this->file['name'] ), 0644)  or die( " can't upload!" );
		
		if($maxwidth == "" && $maxheight = "")
		{
			$this->final = ".".$this->uploaddir.$this->newfile.".".file_extension( $this->file['name'] );
			return (true);
		}

		resize_image( "".$this->uploaddir.$this->newfile.".".file_extension( $this->file['name'] ), $this->maxwidth, $this->maxheight, $this->scale, $this->relscale, $this->jpegquality, $this->pictype );
				
		$this->final = ".".$this->uploaddir.$this->newfile.".".file_extension( $this->file['name'] );
		
		return (true);
	}
}

	function upload_dir($destination)
	{
		$dir = $_SERVER['PHP_SELF'];
		
		for($i=0;$i<strlen($dir);$i++)
		{
			if(substr($dir,$i,1)=="/") $slashpos=$i;
		}
		
		$dir = substr($dir,0,$slashpos);
		$dir = $_SERVER['DOCUMENT_ROOT'].$dir.'/'.$destination;
		return($dir);
	}

	function file_extension($filename)
	{
		$extension = substr( $filename, ( strrpos($filename, '.') + 1 ) ) ;
		$extension = strtolower( $extension ) ;
		
		return $extension;
	}
	
	function resize_image($image_name, $max_width = null, $max_height = null, $scale = null, $relscale = false, $quality = 100, $pictype)
	{
		$img = null;
		$ext = file_extension($image_name);

		if ($ext == 'jpg' || $ext == 'jpeg') {
		    $img = @imagecreatefromjpeg($image_name);
		} else if ($ext == 'png') {
		    $img = @imagecreatefrompng($image_name);
		} else if ($ext == 'gif') {
		    $img = @imagecreatefromgif($image_name);
		}

		if ($img) 
		{
		    list($oldwidth, $oldheight) = getimagesize($image_name);
			
			if( $relscale == true && ( $max_width || $max_height ) )
			{
				if ($oldheight > $oldwidth || !$max_width) 
				{ 
					if($pictype == 'Pic')
					{
						$sizefactor = (double) ($max_height / $oldheight);
					}
					if($pictype == 'Thumbnail')
					{
						$sizefactor = (double) ($max_width / $oldwidth) ;
					}
					$width = (int) ($oldwidth * $sizefactor);
					$height = (int) ($oldheight * $sizefactor);
				} 
				else if($oldheight < $oldwidth || !$max_height)
				{
					$sizefactor = (double) ($max_width / $oldwidth) ;
					$width = (int) ($oldwidth * $sizefactor);
					$height = (int) ($oldheight * $sizefactor);
				}else{
					$width = $max_width;
					$height = $max_height;
				}
			}else if (  $max_width && $max_height && $relscale == false ){   
				$width = $max_width;
				$height = $max_height;
			}else if( $scale && !$max_width || !$max_height ){
				$width = (int) ($oldwidth * ( $scale / 100 ));
				$height = (int) ($oldheight * ( $scale / 100 ));
			}else{
				return false;
			}
			$tmp_img = imagecreatetruecolor($width, $height);
			if ($ext == 'png') {
		    imagealphablending( $tmp_img, false );
			imagesavealpha( $tmp_img, true );     
			}
			
			
			
			
			imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $width, $height, $oldwidth, $oldheight);
			
			imagedestroy($img);
			$img = $tmp_img;
		    
			if ($ext == 'png') {
			    imagepng($img,$image_name);
			} else if ($ext == 'gif') {
			    imagegif($img,$image_name);
			}else{
			    imagejpeg($img,$image_name,$quality);
			}     
		}
	}
?>