<?php

if ( !defined( 'ABSPATH' ) ) exit;

function get_accomm_tags($post_id){

	if ( empty($post_id) ) return false;
	
	global $wpdb;

	$sql_query = "
SELECT  tt.term_id
FROM {$wpdb->prefix}terms AS t
INNER JOIN {$wpdb->prefix}term_taxonomy AS tt
ON t.term_id = tt.term_id
INNER JOIN {$wpdb->prefix}term_relationships AS tr
ON tr.term_taxonomy_id = tt.term_taxonomy_id
WHERE tt.taxonomy IN ('moment_tags')
AND tr.object_id IN ($post_id)";


	$result = $wpdb->get_results($sql_query, ARRAY_A );

	return wp_list_pluck($result,'term_id'); 

}

function get_posts_in_tag( $tag_id, $post_type = 'accommodations' ){

	if ( empty($tag_id) ) return false;

	global $wpdb;

	$sql_query = "
	SELECT {$wpdb->prefix}posts.ID
FROM {$wpdb->prefix}posts
LEFT JOIN {$wpdb->prefix}term_relationships
ON ({$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id)
WHERE 1=1
AND ( {$wpdb->prefix}term_relationships.term_taxonomy_id IN ($tag_id) )
AND {$wpdb->prefix}posts.post_type = '{$post_type}'
AND {$wpdb->prefix}posts.post_status = 'publish'";
	
	$result = $wpdb->get_results($sql_query, ARRAY_A );

	return wp_list_pluck($result,'ID'); 
}	

function get_posts_in_tax( $tag_id, $post_type ){

	if ( empty($tag_id) ) return false;

	global $wpdb;

	$sql_query = "SELECT {$wpdb->prefix}posts.ID
FROM {$wpdb->prefix}posts
LEFT JOIN {$wpdb->prefix}term_relationships
ON ({$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id)
WHERE 1=1
AND {$wpdb->prefix}term_relationships.term_taxonomy_id = {$tag_id} 
AND {$wpdb->prefix}posts.post_type= '$post_type'
AND {$wpdb->prefix}posts.post_status = 'publish'
GROUP BY {$wpdb->prefix}posts.ID
ORDER BY {$wpdb->prefix}posts.post_date DESC";

	$result = $wpdb->get_results($sql_query, ARRAY_A );

	return wp_list_pluck($result,'ID'); 
}
