<?php session_start( ); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html class="ui-mobile landscape min-width-320px min-width-480px min-width-768px max-width-1024px">
	<head>
	<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
	<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Imagize E Books</title>
		<link rel="stylesheet" href="/iserver/books/js/jquery.mobile-1.0a3/jquery.mobile-1.0a3.css" />
<style type="text/css">
    * {
    padding: 0;
    margin: 0;
    font-family: arial, helvetica, sanserif, sans-serif;
  }

#wrapper {
width: 95%;
}
.page {
  width: 95%;
}

h1 {
  background-color: #333333;
  color: #FFFFFF;
  }

a {
  text-decoration: none;
 color: #333333;
}

a:hover {
    text-decoration: underline;
}

h3 img {
	padding-right: 5px;
}

li img {
	hidden: true;	
}
</style>
</head>
<body>
                <input type="text" name="searchbox" />
<div id="wrapper">
<div data-role="page" class="page">
	<div data-role="header">Imagize E Books</div> 
		<input type="button" name="expand-all" value="Expand All" class="expand-all" data-theme="b" data-inline="true" />
		<input type="button" name="collapse-all" value="Collapse All" class="collapse-all" data-theme="b" data-inline="true" />
                <?php
$books = ls("*", "/var/www/iserver/books/_BOOKS", true);
$dir = "";
$div = "";
//echo("<ul>");
foreach ($books as $book) {
  if ( is_dir( "_BOOKS/" . $book ) ) {
    $dir = $book;
	if ( $div != "" ) {
		echo('</div>');
		//		echo('</ul></div>');
	} 
	$div = '<div class="directory" data-role="collapsible" data-collapsed="true" data-theme="e">';
    echo("{$div}" . '<h3><img src="/var/www/iserver/books/images/icons/37-suitcase.png"  />' . "/var/www/iserver/books/{$book}</h3>" . '<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b"  >');

  } else {
    //$new_book = preg_match("/([^\/]+)$/",$book);
    $new_book =  basename($book,'.'.$info['extension']);
    //$img = '<img src="images/icons/96-book.png" />';
	 //    echo <<<EOF
    //  <li><a href="_BOOKS/{$book}" target2="_blank" >{$new_book}</a></li>
    //
    //EOF;
    echo <<<EOF
      <a href="_BOOKS/{$book}" target="_blank" ><input type="button" name="{$new_book}" value="{$new_book}" class="expand-all" data-theme="b" data-inline="true" /></a>

EOF;
		
  }
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
  if($get_files) $both = glob($pattern, GLOB_BRACE + GLOB_MARK);
  if($recursivly or $get_folders) $folders = glob("*", GLOB_ONLYDIR + GLOB_MARK);
    
  //If a pattern is specified, make sure even the folders match that pattern.
  $matching_folders = array();
  if($pattern !== '*') $matching_folders = glob($pattern, GLOB_ONLYDIR + GLOB_MARK);
    
  //Get just the files by removing the folders from the list of all files.
  $all = array_values(array_diff($both,$folders));
        
  if($recursivly or $get_folders) {
    foreach ($folders as $this_folder) {
      if($get_folders) {
	//If a pattern is specified, make sure even the folders match that pattern.
	if($pattern !== '*') {
	  if(in_array($this_folder, $matching_folders)) array_push($all, $this_folder);
	}
	else array_push($all, $this_folder);
      }
            
      if($recursivly) {
	// Continue calling this function for all the folders
	$deep_items = ls($pattern, $this_folder, $recursivly, $options); # :RECURSION:
	foreach ($deep_items as $item) {
	  array_push($all, $this_folder . $item);
	}
      }
    }
  }
    
  if($folder) chdir($current_folder);
  return $all;
}


?>
</ul>
</div>
</div>
		<input type="button" name="expand-all" value="Expand All" class="expand-all" data-theme="b" data-inline="true" />
		<input type="button" name="collapse-all" value="Collapse All" class="collapse-all" data-theme="b" data-inline="true" />

	<div data-role="footer">Imagize E Books</div> 
	<script type="text/javascript" src="/iserver/books/js/jquery-1.5.1.min.js"></script>
	<script type="text/javascript" src="/iserver/books/js/jquery.mobile-1.0a3/jquery.mobile-1.0a3.js" ></script>
	<script type="text/javascript" >
<?php if ($_SESSION['expand_all'] === true ) { ?>
  $(".directory").trigger("expand");
<?php } else { ?>
  $(".directory").trigger("collapse");
<?php } ?>

	    $(".expand-all").click( function( ) { 
		$(".directory").trigger("expand");
		<?php $_SESSION['expand_all'] = true; ?>
            } );
	    $(".collapse-all").click( function( ) { 
		$(".directory").trigger("collapse");
		<?php $_SESSION['expand_all'] = false; ?>
		console.log("directories", $(".directory") );
            } );

	</script>
