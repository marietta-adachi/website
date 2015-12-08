<?php

require_once APPPATH."../../html/blog/wp-blog-header.php";

/

class Wordpress
{

    public static function getPostTopics($category = "news", $count = 1)
    {
	$args = array(
	    "category_name" => $category,
	    "posts_per_page" => $count,
	    "paged" => 1,
	    "post_type" => array("post",),
	    "post_status" => array("publish"),
	    "order" => "DESC",
	    "orderby" => "date",
		//"meta_key" => "order",
		//"orderby" => "meta_value",
	);

	$postList = array();
	$the_query = new WP_Query($args);
	if ($the_query->have_posts())
	{
	    while ($the_query->have_posts())
	    {
		$the_query->the_post();
		$tmp["id"] = get_the_ID();
		$tmp["title"] = get_the_title();
		$tmp["permalink"] = get_the_permalink();
		$postList[] = $tmp;
	    }
	    wp_reset_postdata();
	}

	return $postList;
    }

    public static function getPostList($category, $page = 1, $offset = 0, $countOnly = false)
    {

	$args = array(
	    "category_name" => $category,
	    "posts_per_page" => $page,
	    "paged" => max($offset, 0),
	    "post_type" => array("post",),
	    "post_status" => array("publish"),
	);

	$postList = array();
	$the_query = new WP_Query($args);
	if ($countOnly)
	{
	    return $the_query->found_posts;
	}

	if ($the_query->have_posts())
	{
	    while ($the_query->have_posts())
	    {
		$the_query->the_post();
		$tmp["id"] = get_the_ID();
		$tmp["title"] = get_the_title();
		$tmp["excerpt"] = get_the_excerpt();
		$tmp["permalink"] = get_the_permalink();

		$tmp["thumbnail"] = null;
		if (has_post_thumbnail(get_the_ID()))
		{
		    $tmp["thumbnail"] = get_the_post_thumbnail(get_the_ID(), array(250, 250));
		}

		$postList[] = $tmp;
	    }
	    wp_reset_postdata();
	}
	return $postList;
    }

    public static function getFavoriteList()
    {
	
    }

    public static function getRelatedList()
    {
	
    }

    public static function getPostDetail($id = 1)
    {
	$args = array(
	    "p" => $id,
	);

	$detail = array();
	$the_query = new WP_Query($args);
	if ($the_query->have_posts())
	{
	    while ($the_query->have_posts())
	    {
		$the_query->the_post();
		$detail["id"] = get_the_ID();
		$detail["date"] = get_the_date("Y年n月j日");
		$detail["title"] = get_the_title();
		$detail["excerpt"] = get_the_excerpt();
		$detail["permalink"] = get_the_permalink();
		$detail["content"] = get_the_content();
		$detail["thumbnail"] = get_the_post_thumbnail();
	    }
	    wp_reset_postdata();
	}

	return $detail;
    }

}

?>
