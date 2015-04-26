<?php 

if (!empty($articles)) :

	foreach ($articles as $article) :

		echo '<strong>'.$article->title.'</strong><br>';
		echo $article->content.'<br>';

	endforeach;

	echo $this->pagination->create_links();

else : 
	echo 'Article not found';
endif;

?>