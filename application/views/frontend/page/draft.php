<?php 

if (!empty($article)) :

	echo '<strong>'.$article->title.'</strong><br>';
	echo $article->content.'<br>';

else : 
	echo 'Article not found';
endif;

?>