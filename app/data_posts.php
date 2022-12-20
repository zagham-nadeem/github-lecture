<?php

$page = 1;
if(!empty($_GET['page'])) {
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    if(false === $page) {
        $page = 1;
    }
}

$limit = 10;
if(!empty($_GET['limit'])) {
    $limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);
}

$offset = ($page - 1) * $limit;

header('Content-Type: application/json');
header("access-control-allow-origin: *");

require './app_core.php';

if (getParamsLang()) {

	

	$sqlQuery = "SELECT posts.*,tr_posts.*,tr_categories.tr_name AS category_name, tr_categories.tr_slug AS category_slug FROM posts,tr_posts,tr_categories WHERE posts.post_visibility = 1 AND posts.post_id = tr_posts.tr_post AND posts.post_category = tr_categories.tr_category AND tr_posts.tr_lang = '".getParamsLang()."' AND tr_categories.tr_lang = '".getParamsLang()."'";

	if(getParamsID()){

		$sqlQuery .= " AND posts.post_id = '".getParamsID()."'";
	}

	if(getIDCategory()){

		$sqlQuery .= " AND posts.post_category = '".getIDCategory()."'";
	}

	if(getPostQuery()){

		$sqlQuery .= " AND tr_posts.tr_title LIKE '%".getPostQuery()."%'";
	}

	$sqlQuery .= " ORDER BY posts.post_date";

    if(isset($_GET['page']) && !empty($_GET['page'])) {
        $sqlQuery .= " LIMIT ".$offset.",".$limit;
    }

    if(isset($_GET['limit']) && !empty($_GET['limit']) && !isset($_GET['page'])) {
        $sqlQuery .= " LIMIT ".$limit;
    }
    
    $sentence = $connect->prepare($sqlQuery);

    $sentence->execute();

    $qResults = $sentence->fetchAll(PDO::FETCH_ASSOC);

	$data = array();

	foreach ($qResults as $row) {

		$id = $row['post_id'];
		$title = $row['tr_title'];
		$image = $row['post_image'];
		$category = $row['category_name'];
		$category_id = $row['post_category'];
		$date = $row['post_date'];

		$data[] = array(
			'id'=> $id,
			'title'=> html_entity_decode($title),
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