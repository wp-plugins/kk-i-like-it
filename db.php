<?php

class kkDataBase{
	
	private $wpdb;
	private $tableLike;
	private $tableLikeUser;
	
	public function __construct(){
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->tableLike = $wpdb->prefix . 'kklike';
		$this->tableLikeUser = $wpdb->prefix . 'kklikeuser';
		$this->tableWPUsers = $wpdb->prefix . 'users';
		$this->tableWPPosts = $wpdb->prefix . 'posts';
	}
	
	public function addLike($idPost, $idUser, $type){
		$ip = $_SERVER['REMOTE_ADDR'];
		$data = date('Y-m-d H:i:s');
		$isLike = $this->checkIsLike($idPost,$type);
		
		if($isLike != '0'){
			$userRate = $this->checkUserRating($isLike, $idUser, $ip);
			
			if($userRate == '0'){
			
				$rating = $this->getPostRating($idPost);
				$rating++;
				$result = $this->wpdb->update( $this->tableLike, array( 'rating' => $rating ), array('idwp' => $idPost));
				
				if($result == '1'){
					$result = $this->wpdb->insert( $this->tableLikeUser, array( 'idwpuser' => $idUser, 'idlike' => $isLike, 'ip' => $ip, 'date' => $data ));
						
					$odp = array('hasError' => FALSE, 'rating' => $rating);
				}else{
					$odp = array('hasError' => TRUE, 'rating' => $rating);
				}
			
			}else{
				$odp = array('hasError' => TRUE, 'rating' => '');
			}
			
			return json_encode($odp);
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
			$data = date('Y-m-d H:i:s');
			
			$result = $this->wpdb->insert( $this->tableLike, array( 'idwp' => $idPost, 'rating' => '1', 'type' => $type ));
		
			if($result == 1){
				$id_last = mysql_insert_id();
				$result = $this->wpdb->insert( $this->tableLikeUser, array( 'idwpuser' => $idUser, 'idlike' => $id_last, 'ip' => $ip, 'date' => $data ));
				$odp = array('hasError' => FALSE, 'rating' => '1');
			}else{
				$odp = array('hasError' => TRUE, 'rating' => '');
			}
			
			return json_encode($odp);
		}
		
	}
	
	public function removeLike($idPost, $idUser, $type){
		$ip = $_SERVER['REMOTE_ADDR'];
		$isLike = $this->checkIsLike($idPost,$type);
		
		if($isLike != '0'){
			$userRate = $this->checkUserRating($isLike, $idUser, $ip);
			if($userRate != '0'){
				
				if($idUser != $userRate->idwpuser){
					$odp = array('hasError' => TRUE, 'rating' => '', 'msg' => 'You must be logged in to remove data.');
				}else{
				 
					$sql = "DELETE FROM ". $this->tableLikeUser ." WHERE id = '". $userRate->id ."'";
					$result = $this->wpdb->query($sql);
					if($result == 1){
						$rating = $this->getPostRating($idPost);
						$rating--;
						$result = $this->wpdb->update( $this->tableLike, array( 'rating' => $rating ), array('idwp' => $idPost));
						
						if($result == '1'){
							$odp = array('hasError' => FALSE, 'rating' => $rating);
						}else{
							$odp = array('hasError' => TRUE, 'rating' => $rating);
						}
					}else{
						$odp = array('hasError' => TRUE, 'rating' => '');
					}
					
				}
			}
		}else{
			$odp = array('hasError' => TRUE, 'rating' => '');
		}
		
		return json_encode($odp);
	}
	
	public function checkIsLike($id, $type){
		$val = $this->wpdb->get_var("SELECT id FROM $this->tableLike WHERE idwp = $id AND type='".$type."'");
		
		if($val === NULL){
			$val = 0;
		}
		
		return $val;
	}
	
	public function checkUserRating($idLike, $idUser, $ip){
		if($idUser != '0'){
			$val = $this->wpdb->get_row("SELECT id, idwpuser FROM $this->tableLikeUser WHERE idlike = $idLike AND idwpuser = $idUser");
		}else{
			$val = $this->wpdb->get_row("SELECT id, idwpuser FROM $this->tableLikeUser WHERE idlike = $idLike AND ip = '". $ip ."'");			
		}
		
		if($val === NULL){
			$val = 0;
		}
		
		return $val;
	}
	
	public function getPostRating($id){
		$val = $this->wpdb->get_var("SELECT rating FROM $this->tableLike WHERE idwp = $id");
		
		if($val === NULL){
			$val = 0;
		}
		
		return $val;
	}
	
	public function getInformation($limit = 0){
		$result = array();
		
		if($limit > 0){
			$limit = " LIMIT ".$limit;
		}else{
			$limit = "";
		}
		
		$sql = "SELECT * FROM ". $this->tableLikeUser ." 
				LEFT JOIN (". $this->tableLike .") 
				ON (". $this->tableLikeUser .".idlike = ". $this->tableLike .".id) 
				ORDER BY ". $this->tableLikeUser .".date".$limit;
		$dane = $this->wpdb->get_results($sql);
		
		$i = 0;
		foreach($dane as $row){
			
			if($row->idwpuser == '0'){
				$user = __('Guest', 'lang-kkilikeit');
			}else{
				$user = $this->wpdb->get_var("SELECT display_name FROM $this->tableWPUsers WHERE ID = $row->idwpuser");
			}
			
			$result[$i] = array(
				'ip' 		=> 	$row->ip,
				'date'		=>	$row->date,
				'user'		=>	$user,
				'post_name'	=>	$this->wpdb->get_var("SELECT post_title FROM $this->tableWPPosts WHERE ID = $row->idwp")
			);
			$i++;
		}
		
		return $result;
	}
}