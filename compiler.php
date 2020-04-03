<?php
	function getfile($file_path){
		if(file_exists($file_path)){
			$file_arr = file($file_path);
			for($i=0;$i<count($file_arr);$i++)
				echo $file_arr[$i]."<br />";
		}
	}
	function get_extension($file)
	{
		return pathinfo($file["name"], PATHINFO_EXTENSION);
	}
	$file = $_FILES['file'];
	$filename = $_FILES['file']['name'];
	if(!(get_extension($file)=='cpp'||get_extension($file)=='c')){
		echo 'Uploaded a Bad File!';
		echo '<a href="/">Return</a>';
    	exit();
	}
	system('mv '.$file["tmp_name"].' ./cppsrc/'.$file["name"]);
	if(get_extension($file)=='cpp'){
		system('i586-mingw32msvc-g++ ./cppsrc/'.$file["name"].' -o ./cppsrc/'.$file["name"].'.exe 2>./cppsrc/'.$file["name"].'.log');
	}
	else{
		system('i586-mingw32msvc-gcc ./cppsrc/'.$file["name"].' -o ./cppsrc/'.$file["name"].'.exe 2>./cppsrc/'.$file["name"].'.log');
	}
	if(!file_exists("./cppsrc/".$file["name"].".exe"))
	{
    	echo "Compilation Error!<br/>";
    	if(get_extension($file)=='cpp'){
    		echo "g++:<br/>";
    	}
    	else{
    		echo "gcc:<br/>";
    	}
    	echo "<code>";
    	echo getfile("./cppsrc/".$file["name"].".log");
    	echo "</code>";
    	echo '<a href="/">Return</a>';
    	exit();
	}
	else{
		echo "Congratulations! Compiled Successfully!";
		echo ' <a href="/cppsrc/'.$file["name"].'.exe">Download</a>';
		echo '<br />';
		echo '<a href="/">Return</a>';
	}
?>
