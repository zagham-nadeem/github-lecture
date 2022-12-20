<?php

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang() && getParamsID()) {

	$sqlQuery = "SELECT posts.*,tr_posts.*,tr_categories.tr_name AS category_name FROM posts,tr_posts,tr_categories WHERE posts.post_visibility = 1 AND posts.post_id = tr_posts.tr_post AND posts.post_category = tr_categories.tr_category AND tr_posts.tr_lang = '".getParamsLang()."' AND tr_categories.tr_lang = '".getParamsLang()."' AND posts.post_id = '".getParamsID()."'";

	$sqlQuery .= " LIMIT 1";

    $sentence = $connect->prepare($sqlQuery);

    $sentence->execute();

    $qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

	$data = array();

	foreach ($qResults as $row) {

		$id = $row['post_id'];
		$title = $row['tr_title'];
		$content = $row['tr_content'];
		$image = $row['post_image'];
		$category = $row['category_name'];
		$category_id = $row['post_category'];
		$date = $row['post_date'];

		$data[] = array(
			'id'=> $id,
			'title'=> html_entity_decode($title),
			'content'=> formatHTML($content),
			'image'=> getImage($image),
			'category'=> html_entity_decode($category),
			'category_id'=> $category_id,
			'date'=> formatDate($date),
		);
	}

	print json_encode($data, JSON_NUMERIC_CHECK);

}else{

    $InvalidMSG = 'error';
    
    $InvalidMSGJSon = json_encode($InvalidMSG);
    
    print $InvalidMSGJSon;

}

?>