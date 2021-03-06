<?php
if ( !defined( 'ABSPATH' ) ) exit;

enqueue_my_style('archive-product','/assets/css/archive-product.css');

require_once ( COMPONENTS_PATH.'hero/hero.php' );

require_once ( COMPONENTS_PATH.'cards/cards.php' );

require_once ( trailingslashit( get_stylesheet_directory() ) . '/inc/frontend/products-search.php' );

function hero_prods_listing(){
	
	$args = get_archive_hero_data();

	$args['display-country'] = false;

	$args['type'] = 'page_title';

	the_hero_reduced( $args );

}

add_action('astra_content_before','hero_prods_listing');


function get_archive_hero_data(){

	$page_type = get_page_type_for_archive();

    if( is_blog_page( $page_type ) ) return [	'title'         =>  'Unorthodox travel',
                                                'img-id'        =>  get_field('header_image_desktop'),
                                                'img-mobile-id' =>  get_field('header_image_mobile')
                                            ];

    if( $page_type == 'moment_tags' ) return [
        'title'         =>  get_queried_object()->name,
        'img-id'        =>  29948,
        'img-mobile-id' =>  30164
    ];

	$result = array(	
		'accommodations'	=>	
			['title'=>'Lodging','img-id' => 29948 , 'img-mobile-id' => 30164],
		
		'moments'		=>	
			['title'=>'Experiences','img-id' => 29949 , 'img-mobile-id' => 30165],
		
		'landing-page'		=>	
			['title'=>'Destinations','img-id' => 29950, 'img-mobile-id' =>30166 ]

	);

	return $result[ $page_type ] ?? ['title'=>'No data','img-id' => 15829];
}

function get_page_type_for_archive(){

	global $wp;

	if( !isset($wp->query_vars['post_type']) && !isset($wp->query_vars['pagename'])) return 'moment_tags';

    return $wp->query_vars['pagename'] ?? $wp->query_vars['post_type'];
}

function is_blog_page( $page_type ){

    return $page_type == 'the-explorer';
}

function get_current_page_uri() {

	return parse_url($_SERVER['REQUEST_URI'])['path'];

}

function the_tag_button($terms) {

	$current_page_uri = get_site_url().get_current_page_uri();

	$location_get_var = (isset_location()) ? '&location='.isset_location() : '';																				
	foreach ( $terms as $term ) {

		$terms_list = isset($_GET['tags']) ? $_GET['tags'] . ',' . $term->term_id : $term->term_id;

		?>
		<a href="<?=$current_page_uri?>?tags=<?=$terms_list?><?= $location_get_var ?>" class="prim-grad white txt-center"><?=$term->name?></a>
		<?php

	}

}


function get_current_taxonomy() {

    $page_type = get_page_type_for_archive();

    if( is_blog_page( $page_type ) ) return 'post_tag';

    return 'moment_tags';

}


function the_selected_tag( $selectedTags ){

	if ( empty($selectedTags[0]) ) return;

	foreach( $selectedTags as $tagId ) {

		$tag = get_term_by('term_id',$tagId, get_current_taxonomy());

		if( !is_int($tagId) ) $tag = get_term_by('slug', $tagId, get_taxonomy_by_tax_slug($tagId));

		$remove_link = is_int($tagId) ? get_removed_termid_uri( $selectedTags, $tag->term_id ) : get_removed_termid_uri( $selectedTags, $tag->slug )

		?>
		<a href="<?= $remove_link ?>" class="prim-grad white txt-center selected-tag-link">
			<?php
                echo $tag->name;

			    the_icon('cancel-white', false );
			?>
		</a>
		<?php
	}
}


function get_removed_termid_uri( $selectedTags, $termId ){

	$current_url = get_site_url().get_current_page_uri();

	if ( is_last_tag() && !isset_location() ) return $current_url;

	if( !is_int($termId) ) array_pop($selectedTags); // Remove location slug from selected tags array

    $result = array();

	foreach( $selectedTags as $tagId ) {

		if ( $termId === $tagId || !is_int($tagId) ) continue;

		$result[] = $tagId;
	}

	return get_url_after_remove($result, $current_url, $termId);
}

function get_url_after_remove($result, $curr_url, $termId) {

    $url = ( empty($result) ) ? $curr_url : $curr_url . '?tags='.implode(',', $result);

    $url_location_part = ( empty($result) ) ? '?location=' . isset_location() : '&location=' . isset_location();

    if( is_int($termId) && isset_location() ) $url .= $url_location_part;

    return $url;

}

function is_last_tag(){

	return !has_string($_GET['tags'], ',');
}

function get_new_url( $termId ) { //deprecated

	if( isset($_GET['tags']) && !has_string($_GET['tags'], ',')) return remove_term_id_from_url($termId, true);

	$tag_id_removal_string = has_string($_GET['tags'], $termId . ',') ? $termId . ',' : ',' . $termId;

	return remove_term_id_from_url($tag_id_removal_string);

}

function remove_term_id_from_url ( $string, $is_last = false) {//deprecated

	if(!$is_last) return get_current_page_uri();

	$str = str_replace($string, '', $_GET['tags']);

	$str = '?tags=' . $str;

	return $str;

}


function get_terms_by_post_type( $taxonomies, $args=array() ){

	$args = wp_parse_args($args);


	if( !empty($args['post_types']) ){

		$args['post_types'] = (array) $args['post_types'];

		add_filter( 'terms_clauses','filter_terms_by_post_type',10,3);

		function filter_terms_by_post_type( $pieces, $tax, $args){

			global $wpdb;

			$pieces['fields'] .=", COUNT(*) " ;

			$pieces['join'] .=" INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id 
								INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id ";

			$post_types_str = implode("','",$args['post_types']);

			$pieces['where'].= " AND p.post_type IN('".$post_types_str."') GROUP BY t.term_id";

			remove_filter( current_filter(), __FUNCTION__ );

			return $pieces;
		}

	}

	return get_terms($taxonomies, $args);

}


function check_id_in_selected_tags($id) {

	$selectedTags = (array) get_selected_tags_ids();

	if( in_array($id, $selectedTags) ) return true;

	return false;

}


function get_query_posts_taxes($query_post) {

	if(empty($query_post)) return array();

	$taxes = array();

	foreach ($query_post as $post_id) {

		$post_taxes = get_the_terms( $post_id, get_current_taxonomy() );

		if ( ! is_wp_error( $post_taxes ) && $post_taxes ) {

			foreach ( $post_taxes as $post_tax ) {

				if ( ! isset( $brands[$post_tax->term_id] ) && !check_id_in_selected_tags($post_tax->term_id) ) {

					$taxes[$post_tax->term_id] = $post_tax;

				}

			}

		}

	}

	return $taxes;

}


function get_taxes_by_other_tax( $post_type, $tax_query = false ) {

	$args = array(
		'post_type' => $post_type,
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'no_found_rows' => true,
		'update_post_meta_cache' => false,
		'fields' => 'ids', // not all post data needed here
		'tax_query' => $tax_query ? $tax_query : get_tax_query_var(),
	);

	$query = new WP_Query( $args );

	$taxes = get_query_posts_taxes($query->posts);

	usort($taxes, "custom_sorting");

	$taxes = array_reverse($taxes);

	return $taxes;

}


function custom_sorting($a, $b) {

    if ($a->count == $b->count) return 0;

    return ($a->count < $b->count) ? -1 : 1;

}


function the_selected_tags() {

	$selectedTags = get_selected_tags_ids();

    if( empty($selectedTags) && !isset_location() && !isset(get_queried_object()->term_id) ) return;

    if( isset_location() ) $selectedTags[] = isset_location();

//    if( isset(get_queried_object()->term_id) ) $selectedTags[] = get_queried_object()->term_id;

    ?>
	<div class="product_listing_selected_tags filter_tags">
		<?php the_selected_tag($selectedTags); ?>
	</div>
	<?php
}


function display_the_tags($terms) {

	?>
	<div class="product_listing_tags_main secon-grad row-fullwidth">
		<h3 class="heading3 white txt-center">Favourite categories</h3>
		<?php the_selected_tags(); ?>
		<div class="product_listing_tags">
			<div class="product_listing_tags_container filter_tags">
				<?php the_tag_button($terms); ?>
			</div>
		</div>
	</div>
	<?php
}


function remove_term_from_array_by_id($terms_array, $term_id) {

    foreach( $terms_array as $key => $term ) {

        if( $term->term_id == $term_id ) {

            unset($terms_array[$key]);

        }

    }

    return $terms_array;

}


function display_terms_archive_tags($post_types) {

    $current_term = get_queried_object();

    $tax_query = array(
            array(
                'taxonomy' => $current_term->taxonomy,
                'field' => 'term_id',
                'terms' => $current_term->term_id,
            )
    );

    $terms = get_taxes_by_other_tax($post_types, $tax_query);

    $terms = remove_term_from_array_by_id($terms, $current_term->term_id);

    display_the_tags($terms);

    return true;

}


function the_prods_listing_tags($post_type, $taxonomy_archive = false) {

    if( $taxonomy_archive ) return display_terms_archive_tags($post_type);

	$terms = get_terms_by_post_type(get_current_taxonomy(), array(
		'parent' => 0,
		'hide_empty' => 1,
		'orderby' => 'count',
		'order'         => 'DESC',
		'post_types' => $post_type
	));

	if(isset($_GET['tags']) || isset_location()) $terms = get_taxes_by_other_tax($post_type);

	if ( !is_wp_error( $terms ) ){

		display_the_tags($terms);

	}

}


function check_selected_tags() {

	if(!isset($_GET['tags']) && !isset(get_queried_object()->term_id)) return false;

    if( isset($_GET['tags']) ) $tagsIds = $_GET['tags'];

    if( !isset($tagsIds) ) {
        $tagsIds = get_queried_object()->term_id;
    } else {
        $tagsIds .= ',' . get_queried_object()->term_id;;
    }

	if(strpos($tagsIds, ',') !== false) {

		$tagsIds = explode(',', $tagsIds);

	}

	return (array) $tagsIds;

}


function get_selected_tags_ids() {

    if(!check_selected_tags()) return false;

    $selectedTagsIds = array();

    $tagsIds = check_selected_tags();

    foreach($tagsIds as $tagId) {

        $term = get_term( $tagId, get_current_taxonomy() );

        array_push($selectedTagsIds, $term->term_id);

    }

    return $selectedTagsIds;
}


function get_taxonomy_by_tax_slug($tax_slug) {

    $term = get_term_by('slug', $tax_slug, 'countries');

    if( !$term ) $term = get_term_by('slug', $tax_slug, 'cities');

    return $term->taxonomy;

}

function get_selected_tags_relations() {

    if(!isset($_GET['tags']) && !isset_location()) return false;

    $termsRelation = array('relation' => 'AND',);

    $idsArray = get_selected_tags_ids();

    if( $idsArray && isset_location() ) $idsArray[] = isset_location();

    if( !$idsArray && isset_location() ) $idsArray = array(isset_location());

    foreach($idsArray as $id) {

        $tax_condition = array(
            'taxonomy' => get_current_taxonomy(),
            'field' => 'term_id',
            'terms' => $id,
            'operator' => 'IN',
        );

        if( !is_int($id) ) {

            $tax_condition['field'] = 'slug';
            $tax_condition['taxonomy'] = get_taxonomy_by_tax_slug($id);

        }

        array_push($termsRelation, $tax_condition);

    }

    return $termsRelation;

}


function get_tax_query_var() {

	$selected_tags_relation = get_selected_tags_relations();

	if(isset($_GET['tags']) || isset_location()) return array($selected_tags_relation);

	return false;

}


function products_loop( $query, $post_type ) {

	$display_country_status = get_display_country_status($post_type);

	while ($query -> have_posts()) : $query -> the_post();

		$country_name = $display_country_status ? get_product_country_name() : false;

		the_card_product( ['text'=>get_the_title(), 'url'=>get_the_permalink(), 'country'=>$country_name, 'img-id'=>get_post_thumbnail_id(get_the_ID())] );

	endwhile;

}

function get_product_country_name(){

	$terms = get_the_terms( get_the_ID(), 'countries' );

	return ($terms) ? $terms[0]->name : false;

}

function get_display_country_status($post_type){

	return ($post_type[0] ?? false) !=='landing-page';
}

function get_pagination_icon() {
    ob_start();?>
    <svg width="6" height="8" viewBox="0 0 6 8" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0.307739 0.943344L3.3644 4L0.307739 7.05666L1.25105 8L5.25105 4L1.25105 -4.12335e-08L0.307739 0.943344Z" fill="white"/>
    </svg>
    <?php
    $icon = ob_get_clean();

    return $icon;
}

function the_pagination($query) {

    $big = 999999999; // need an unlikely integer
																																  
		 

    echo paginate_links( array(
        'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $query->max_num_pages,
        'prev_text' => get_pagination_icon(),
        'next_text' => get_pagination_icon(),
    ) );
}


function the_products_grid($post_type = 'accommodations') {

    $query_args = array(
        'posts_per_page'=> 9,
        'post_type'=> $post_type,
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
        'tax_query' => get_tax_query_var()
    );

    if(check_search_page()) $query_args['s'] = get_search_str();

    $the_query = new WP_Query( $query_args );
														  
    ?>
	   

    <div class="products_listing_grid_container div-center">
        <div class="products_listing_grid">
             <?php products_loop($the_query, $post_type); ?>
        </div>
    </div>

    <div class="products_listing_grid_pagination txt-center">
        <?php the_pagination($the_query); ?>
    </div>

    <?php
    wp_reset_postdata();

}


function get_post_type_label($post_type) {

    $post_obj = get_post_type_object( $post_type );

    if( $post_type == 'post' ) return 'Articles';

    if( is_array($post_type) && in_array('landing-page-cities', $post_type ) ) return 'Destinations';

    return isset($post_obj->label) ? $post_obj->label : '';

}


function check_search_page() {

    if(!isset($_GET['search'])) return false;

    return true;

}

function is_selected_tags() {

    return !empty($_GET['tags']);

}
function get_search_str() {

    if(!check_search_page()) return false;

    return $_GET['search'];

}

function isset_location() {

    return isset($_GET['location']) ? $_GET['location'] : false;

}
function the_tags_title() {

										  
    ?>

    <div class="product-search-text-wrapper div-center">
        <h2 class="body-txt secon product-sub-title">Results for selected categories:</h2>
    </div>

    <?php
}

function the_search_title() {
?>

    <div class="product-search-text-wrapper div-center">
        <h2 class="body-txt secon product-sub-title"><span>This is what we found for your search query</span> ???<?= $_GET['search'] ?>???:</h2>
    </div>

<?php
}


function the_sub_title() {

    if(check_search_page()) the_search_title();

    if(is_selected_tags()) the_tags_title();

}


function get_product_post_type($post_type) {

    if( $post_type == 'landing-page' && isset_location() ) return $post_type = 'landing-page-cities'; //Changing post type to city for regions listing;

    return $post_type;

}


function the_archive($post_type, $taxonomy_archive = false) {

    $post_type = get_product_post_type($post_type);

    get_header();
    ?>
        <div id="primary">

            <?php

            the_prods_listing_tags($post_type, $taxonomy_archive);

            the_products_search($post_type, get_post_type_label($post_type));

            the_sub_title();

            the_products_grid($post_type);

            ?>


        </div><!-- #primary -->
    <?php

    enqueue_my_script('archive-product','/assets/js/search-product.js');

    get_footer();

}



