<?php
$books = ls("*", "/var/www/iserver/books/_BOOKS", true);
//$books = ls("*", "/home/ecdown/src/web_examples", true);
echo json_encode($books);


function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}
function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}


/**
 * This funtion will take a pattern and a folder as the argument and go thru it(recursivly if needed)and return the list of 
 *               all files in that folder.
 * Link             : http://www.bin-co.com/php/scripts/filesystem/ls/
 * Arguments     :  $pattern - The pattern to look out for [OPTIONAL]
 *                    $folder - The path of the directory of which's directory list you want [OPTIONAL]
 *                    $recursivly - The funtion will traverse the folder tree recursivly if this is true. Defaults to false. [OPTIONAL]
 *                    $options - An array of values 'return_files' or 'return_folders' or both
 * Returns       : A flat list with the path of all the files(no folders) that matches the condition given.
 */
function ls($pattern="*", $folder="", $recursivly=false, $options=array('return_files','return_folders')) {
  if($folder) {
    $current_folder = realpath('.');
    if(in_array('quiet', $options)) { // If quiet is on, we will suppress the 'no such folder' error
      if(!file_exists($folder)) return array();
    }
        
    if(!chdir($folder)) return array();
  }
    
    
  $get_files    = in_array('return_files', $options);
  $get_folders= in_array('return_folders', $options);
  $both = array();
  $folders = array();
    
  // Get the all files and folders in the given directory.
  if($get_files) 
  {
    $both = glob($pattern, GLOB_BRACE + GLOB_MARK);
  }
  if($recursivly or $get_folders) 
  {
    $folders = glob("*", GLOB_ONLYDIR + GLOB_MARK);
  }
    
  //If a pattern is specified, make sure even the folders match that pattern.
  $matching_folders = array();
  if($pattern !== '*') 
  {
     $matching_folders = glob($pattern, GLOB_ONLYDIR + GLOB_MARK);
  }
    
  //Get just the files by removing the folders from the list of all files.
  $temp_all_files = array_values(array_diff($both,$folders));
  $all = array();
  foreach($temp_all_files as $file)
  {
    //echo $file;
    array_push ($all,array($file => array("name" => $file,"display" => $file, "type" => 'file')));
  } 
  
  if($recursivly or $get_folders) {
    foreach ($folders as $this_folder) {
      if($get_folders) {
	//If a pattern is specified, make sure even the folders match that pattern.
	if($pattern !== '*') {
	  if(array_key_exists($this_folder, $matching_folders)) 
          {
            array_push($all, array( $this_folder => array("name" => $this_folder,"display" => $this_folder,"type" => 'folder')));
          }
	}
	else 
        {
          array_push($all, array( $this_folder => array("name"=> $this_folder,"display" => $this_folder,"type" => 'folder')));
        }
      }
            
      if($recursivly) {
	// Continue calling this function for all the folders
	$deep_items = ls($pattern, $this_folder, $recursivly, $options); # :RECURSION:
	foreach ($deep_items as $item) {
          if (is_array($item))
          {
            if(endsWith($item[array_keys($item)[0]]["name"],"/" ))
            {
               array_push($all, array($this_folder . $item[array_keys($item)[0]]["name"] => array("name" => $this_folder . $item[array_keys($item)[0]]["name"],"display" => $this_folder . $item[array_keys($item)[0]]["name"],"type" => "folder")));
                
            }
            else
            {
            array_push($all, array($this_folder . $item[array_keys($item)[0]]["name"] => array("name" => $this_folder . $item[array_keys($item)[0]]["name"],"display" => $this_folder . $item[array_keys($item)[0]]["name"],"type" => "file")));
            }
            
          }
          else
          {
            array_push($all, array($this_folder . $item => array("name" => $this_folder . $item,display => $this_folder . $item,"type" => "file")));
          }
	}
      }
    }
  }
    
  if($folder) chdir($current_folder);
  return $all;
}

?>
