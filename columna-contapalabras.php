<?php

add_filter( 'manage_edit-post_columns', 'my_columns_filter', 10, 1 );
function my_columns_filter( $columns ) {
	$column_wordcount = array( 'wordcount' => 'Palabras' );
	$columns = array_slice( $columns, 0, 3, true ) + $column_wordcount + array_slice( $columns, 3, NULL, true );
	return $columns;
}

add_action( 'manage_posts_custom_column', 'my_column_action', 10, 1 );
function my_column_action( $column ) {
	global $post;
	echo str_word_count( $post->post_content );
}

?>