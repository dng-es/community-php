<?php
    /**
     * FileSystem
     * 
     * Operaciones con el sistemas de archivos
     * 
     * @package 
     * @author dng-es
     * @copyright 2015
     * @version 1.0
     * @access public
     */
	class FileSystem {

		/**
		* Show all folders within an existing folder
		*
		* @param 	string 			$dirname 			Folder to show folders
		* @return 	boolean/array	returns false is $dirname is not a folder, otherwise returns an array of folder items
		*/	
		public static function showDirFolders($dirname) {
			$i = 0;
			$arrayFolders = array();
		   	if (is_dir($dirname)) {    //Operate on dirs only
				if ($dh = opendir($dirname)) { 
					while (($file = readdir($dh)) !== false) { 
						if (is_dir($dirname . $file) && $file!="." && $file!=".."){ 
							$arrayFolders[$i] = $file;
							$i++;
						} 
					} 
					closedir($dh); 
					sort($arrayFolders);
					return $arrayFolders;
				} 
			}else{
				return false;    //Return false if attempting to operate on a file
			}
		}

		/**
		* Remove all files and folder from a given folder name
		*
		* @param 	string 			$dirname 			Folder to clean
		* @param 	string 			$nombre_fichero		file which determinate the date limit to remove existing files
		* @return 	boolean/array	returns false is $dirname is not a folder, otherwise returns an array of deleted items
		*/	
		function cleanDir($dirname, $nombre_fichero) {
		   if (is_dir($dirname)) {    //Operate on dirs only
		       $result=array();
		       if (substr($dirname,-1)!='/') {$dirname.='/';}    //Append slash if necessary
		       $handle = opendir($dirname);
		       while (false !== ($file = readdir($handle))) {		      
		           if ($file!='.' && $file!= '..') {    //Ignore . and ..
		               $path = $dirname.$file;
					   //echo 'entra dir 2 '.$path;
		               if (is_dir($path)) {    //Recurse if subdir, Delete if file
		                   $result=array_merge($result,self::rmdirtree($path));
		               }
					   elseif (filectime($path) <= (filectime($dirname.$nombre_fichero)-1000))
					   {
						   unlink($path);
		                   $result[].=$path;
		               }
		           }
		       }
		       closedir($handle);
		       //rmdir($dirname);    //Remove dir
		       $result[].=$dirname;
		       return $result;    //Return array of deleted items
		   }else{
		       return false;    //Return false if attempting to operate on a file
		   }
		}

		/**
		* Create a file with content
		*
		* @param 	string 			$fileName 			File name
		* @param 	string 			$fileContent		File content
		*/	
		public static function createFile( $fileName, $fileContent ){
			$fp = fopen($fileName, 'w+');
			if (fwrite($fp, $fileContent)){
				fclose($fp);
				return true;
			}
			else return false;
		}	

		/**
		* Get class annotations
		*
		* @param 	string 			$class 				Class name
		* @return 	array 			$annotations		Class annotations
		*/	
		public static function getClassAnnotations($class){       
		    $r = new ReflectionClass($class);
		    $doc = $r->getDocComment();
		    preg_match_all('#@(.*?)\n#s', $doc, $annotations);
		    return $annotations;
		}

		/**
		* Print class annotations
		*
		* @param 	string 			$className 			Class name
		* @return 	array 			$annotations		Class annotations
		*/	
		function getAnnotations($className) {
			$annotations_array = array();
			$i=0;
			$annotations = self::getClassAnnotations($className);
			foreach ($annotations as $annotation):
				$annotations_array[$i] = $annotation;
				$i++;
			endforeach;
			return $annotations_array;
		}	

		/**
		* Remove all files and folder from a given folder name
		*
		* @param 	string 			$dirname 			Folder to clean
		* @param 	string 			$nombre_fichero		file which determinate the date limit to remove existing files
		* @return 	boolean/array						returns false is $dirname is not a folder, otherwise returns an array of deleted items
		*/
		public static function rmdirtree($dirname, $nombre_fichero) {
		   if (is_dir($dirname)) {    //Operate on dirs only
		       $result=array();
		       if (substr($dirname,-1)!='/') {$dirname.='/';}    //Append slash if necessary
		       $handle = opendir($dirname);
		       while (false !== ($file = readdir($handle))) {		      
		           if ($file!='.' && $file!= '..') {    //Ignore . and ..
		               $path = $dirname.$file;
					   //echo 'entra dir 2 '.$path;
		               if (is_dir($path)) {    //Recurse if subdir, Delete if file
		                   $result=array_merge($result,self::rmdirtree($path));
		               }
					   elseif (filectime($path) <= (filectime($dirname.$nombre_fichero)-1000))
					   {
						   unlink($path);
		                   $result[].=$path;
		               }
		           }
		       }
		       closedir($handle);
		       //rmdir($dirname);    //Remove dir
		       $result[].=$dirname;
		       return $result;    //Return array of deleted items
		   }else{
		       return false;    //Return false if attempting to operate on a file
		   }
		}				

	}
?>