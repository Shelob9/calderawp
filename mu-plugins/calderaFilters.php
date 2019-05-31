<?php
/**
 * Plugin Name: Caldera Mailchimp Filters
 */
add_filter( 'CalderaMailChimp/useDevServer', '__return_true');
add_action( 'CalderaMailChimp',function (){
    add_filter( 'CalderaMailChimp/fieldsToHide', function($hides,$form){
        if ('f402a6993d' === $form->getListId()) {
            return [
                'a9c6b55e31',//Relationship to CF Pro
                '0bba7d9ced'//Other Groups
            ];
        }
        return $hides;
    },10,2);

});
