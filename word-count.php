<?php
/*
Plugin Name: Word Counter_adv

Description: Count the number of words you inserted in a wordpress post
Version: 1.0
Author: EMIL BENNY

License: GPLv2 or later
Text Domain: word-count
Domain Path: /languages/
*/

function wordcount_load_textdomain() {
    load_plugin_textdomain( 'word-count', false, dirname( __FILE__ ) . "/languages" );
}

add_action( "plugins_loaded", 'wordcount_load_textdomain' );

function wordcount_count_words( $content ) {
    $stripped_content = strip_tags( $content );
    $wordn            = str_word_count( $stripped_content );
    $label            = __( 'Total Number of Words', 'word-count' );
    $label            = apply_filters( "wordcount_heading", $label );
    $tag              = apply_filters( 'wordcount_tag', 'h2' );
    $content          .= sprintf( '<%s>%s: %s</%s>', $tag, $label, $wordn, $tag );

    return $content;
}

add_filter( 'the_content', 'wordcount_count_words' );

function wordcount_reading_time( $content ) {
    $stripped_content = strip_tags( $content );
    $wordn            = str_word_count( $stripped_content );
    $reading_minute   = floor( $wordn / 200 );
    $reading_seconds  = floor( $wordn % 200 / ( 200 / 60 ) );
    $is_visible       = apply_filters( 'wordcount_display_readingtime', 1 );
    if ( $is_visible ) {
        $label   = __( 'Total Reading Time', 'word-count' );
        $label   = apply_filters( "wordcount_readingtime_heading", $label );
        $tag     = apply_filters( 'wordcount_readingtime_tag', 'h4' );
        $content .= sprintf( '<%s>%s: %s minutes %s seconds</%s>', $tag, $label, $reading_minute, $reading_seconds, $tag );
    }

    return $content;
}

add_filter( 'the_content', 'wordcount_reading_time' );







