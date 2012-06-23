<?php
global $like;
$like = new kkDataBase;

function addLike() {
	global $like, $wp_options;
	
	$user = get_current_user_id();
	
	if($wp_options['only_users'] == 'on' && $user == '0'){
		$odp = array('hasError' => TRUE, 'rating' => '', 'msg' => 'Only registered users can vote.');
		echo json_encode($odp);
		die();
	}
	
	$data = $like->addLike($_POST['idPost'], $user, $_POST['type']);
	echo $data;
	
	die();
}
add_action('wp_ajax_add_like', 'addLike');
add_action('wp_ajax_nopriv_add_like', 'addLike');


function removeLike() {
	global $like;
	$user = get_current_user_id();
	
	$data = $like->removeLike($_POST['idPost'], $user, $_POST['type']);
	echo $data;
	
	die();
}
add_action('wp_ajax_remove_like', 'removeLike');
add_action('wp_ajax_nopriv_remove_like', 'removeLike');