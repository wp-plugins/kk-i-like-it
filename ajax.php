<?php
global $like;
$like = new kkDataBase;

function addLike() {
	global $like, $kkLikeSettings;
	
	$user = get_current_user_id();
	
	if($kkLikeSettings['only_users'] == 'on' && $user == '0'){
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








add_action('wp_ajax_kklike_db_update', 'updateLikeDB');

function updateLikeDB() {
    
    global $wpdb;
    $table_name = $wpdb->prefix . "kklike";
	$mataName = 'kklike_value';
	$msg = '';
	
	$vals = $wpdb->get_results("SELECT * FROM $table_name");
	
	foreach($vals as $val){
		
		if(get_post_meta($val->idwp, $mataName) == ""){
			
			add_post_meta($val->idwp, $mataName, $val->rating, true);
			
		}elseif($val->rating != get_post_meta($val->idwp, $mataName, true)){
						
			update_post_meta($val->idwp, $mataName, $val->rating);
			
		}
		
	}
	
	$msg .= __('Data regarding number of likes has been moved successfully.<br />','lang-kklike');
	
	$sql = "DROP TABLE $table_name";
    $results = $wpdb->query($sql);
	
	$msg .= __('Data base has been cleared.<br />','lang-kklike');
	
	$odp = array('hasError' => FALSE, 'msg' => $msg);
	$odp = json_encode($odp);
	
	echo $odp;
	die();
}