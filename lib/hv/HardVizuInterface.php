<?php

/*
 * This file is part of the HardVizu package.
 *
 * (c) Matthieu Deroubaix <matthieu.deroubaix@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HardVizu;

interface HardVizu {

	CONST BASEURL = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/";

	/**
	 * construct with little debug possibilities
	 **/
	public function __construct(){

		$this->debug = false;

		if($this->debug === true){
			@ini_set('display_errors', 'on');
			@error_reporting(E_ALL | E_STRICT);
			set_time_limit(0);
		}

	}

	/**
	 * Render all images with flush for instant casting
	 *
	 * @return jquery object !
	 * 
	 **/

	public static function render($images_path,$css_container){


		$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($images_path));

		$images = array(); 

		foreach ($rii as $file) {

		    if ($file->isDir()){ 
		        continue;
		    }

		    $images[] = $file->getPathname(); 

		}

		// Pleasures of randoms visualization
		$thumbs_rand = array( 1400, 1050, 700, 350 );

		$output = 0;

		if(!empty($images)){
		
			$imagine = new Imagine\Gd\Imagine();

			$except = array("jpeg", "png", "gif", "jpg", "bmp");
			
			$img_formats = implode('|', $except);

			foreach ($images as $key => $path) {

				if(!preg_match('/^.*\.('.$img_formats.')$/i', $path)){
					// Not good format
					continue;
				}
				
				$array_rand = array_rand($thumbs_rand);
				
				$rand = $thumbs_rand[$array_rand];

				$thumb_file = "thumb-" . $rand . "-" . basename(strtolower($path)) . '.jpg';
				
				$thumb_path = "cache/" . $thumb_file;

				$thumb = array('thumb' => self::BASEURL . $thumb_path, 'path' => $path , 'size' => $array_rand);

				if(!file_exists('./' . $thumb_path)){

					$image = $imagine->open($path);
					
					$size  = $image->getSize();
					
					if($size->getHeight() > $size->getWidth()){
						// Portrait picture
						$image->rotate(90);
					}

					$thumbnail = $image->thumbnail(new Imagine\Image\Box($rand,$rand));

					$thumbnail->save($thumb_path);

				}

				$col = round(9/((int)$array_rand+1));

				echo '
					$(\'
					<div class="col-md-'.$col.' thumbs">
						<div class="wrap">
							<img src="'.$thumb['thumb'].'" />
							<div class="zone text-center">
								<a href="'.$thumb['path'].'" class="btn-zoom"><i class="glyphicon glyphicon-resize-full"></i></a>
								<a href="mailto:?subject=Photo!&amp;body='.$thumb['path'].'" class="btn-mail"><i class="glyphicon glyphicon-mail"></i></a>
								<a data-path="'.$thumb['path'].'" class="btn-remove" href="#"><i class="glyphicon glyphicon-trash"></i></a>
							  </div>
						</div>
					</div>
					\').appendTo("'.$css_container.'");
				';

				$output++;

				if( $output % 10 == 0 ){
					echo '<script>$("'.$css_container.'").masonry();</script>';
				}

				ob_flush(); 
				flush(); 

			}

		}

	}

	/**
	 * Render async request
	 */

	public static function request(){

		if(isset($_REQUEST['f'])){

			$f = str_replace(self::BASEURL. "cache", './photos', $_REQUEST['f']);
			$target = str_replace(self::BASEURL, './', $_REQUEST['f']);

			if(file_exists($f)){

				if(copy($f, './old/'.$target)){
					unlink($target);
				}

			}

			die;

		}

	}

}

?>