<?php
$conn = new PDO('mysql:host=localhost;charset=utf8', 'collector', 'passtool') or die('连接数据库失败;');
$sth = $conn->prepare('insert into manules.tp321man(filename, title, contents_src, contents_text, id) values(:filename, :title, :contents_src, :contents_text, :id)');
$sth->bindparam(':filename', $filename);
$sth->bindparam(':title', $title);
$sth->bindparam(':contents_src', $contents_src);
$sth->bindparam(':contents_text', $contents_text);
$sth->bindparam(':id', $id);
for ($index = 0; $index <= 202; $index++){
	$id = $index;

	$filename = $index.'.html';
	echo "Inserting $filename to manules.tp321man.\n";

    $relativePath = './'.$index.'.html'; 
    $fileAbsPath = realpath($relativePath);
    $contents_src = file_get_contents($fileAbsPath, true);

	$text_line_end = '--lf--';
	$contents_text = str_replace('<br />', $text_line_end, $contents_src);
	
	$contents_text = htmlspecialchars($contents_text);
	$pos_start = strrpos($contents_text, 'book-content');
	$pos_start = strpos($contents_text, '&lt;', $pos_start);

	$pos_end = strrpos($contents_text, 'book-footer');
	$pos_end = strrpos($contents_text, '</div>', -(strlen($contents_text) - $pos_end));
	$contents_text = substr($contents_text, $pos_start, ($pos_end - $pos_start));


	$lines = file($fileAbsPath);
	foreach($lines as $line){
		if(false !== strpos($line, 'h1')){
			$title = strip_tags($line);
			break;
		}
	}

	$sth->execute();

	/*
	if($contents_text){
		$conn->exec("update table manules.tp321man set contents_text='$contents_text'  where id=$index;");
	}
	 */
}
