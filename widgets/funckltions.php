<?php
// function example_ajax_request() {
//     $nonce = $_POST['nonce'];
//     if( !wp_verify_nonce( $nonce, 'phjs')) {
//         die('Nonce could not be verified');
//     }

//     if( isset($_REQUEST) ) {
//         $fruit = $_REQUEST['fruit'];
//         echo $fruit;
//     }
//     die();
// }
// add_action('wp_ajax_example_ajax_request', 'example_ajax_request');
// add_action('wp_ajax_nopriv_example_ajax_request', 'example_ajax_request');