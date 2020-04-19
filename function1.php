<?php

/*
Plugin Name: Create Posts from API JSON
Plugin URI: http://jesse.earth/my-first-plugin
Description: Poll Restful API, parse JSON responses and create posts automatically.
Version: 0.1
Author: Jesse Dahlstrom
Author URI: http://jesse.earth
*/

if(!class_exists('WP_CLI'))
return;
function update_data_from_external_api(){

$reddit_data = wp_remote_get( 'https://www.reddit.com/r/Wordpress/.json' );
 
$reddit_data_decode = json_decode( $reddit_data['body'] );

foreach ( $reddit_data_decode->data->children as $item ) {
     $post_title    = $item->data->title; // post title
     $reddit_author = $item->data->author; // author
     $up_votes      = $item->data->ups; // up votes
 
     $my_post = array(
          'post_title'  => $post_title,
          'post_status' => 'publish',
          'post_type'   => 'post',
     );
 
     $post_id = wp_insert_post( $my_post );
          }
      }  

WP_CLI::add_command('jst-update-data', 'update_data_from_external_api');
?>