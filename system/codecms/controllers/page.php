<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeCMS an alternative responsive open source cms made from Philippines.
 *
 * @package     CodeCMS
 * @author      @jsd
 * @copyright   Copyright (c) 2013
 * @license     http://creativecommons.org/licenses/by-sa/3.0/deed.en_US
 * @link        https://bitbucket.org/jsdecena/codecms
 * @since       Version 0.1
 * 
 */

class Page extends CI_Controller {
        
    public function __construct(){

        parent::__construct();

        // START DYNAMICALLY ADD STYLESHEETS
        $css = array(
            'assets/css/bootstrap.css',
            'assets/templates/default/css/default.css',
            'assets/css/bootstrap-responsive.css'
        );

        $this->template->stylesheet->add($css);
        // END DYNAMICALLY ADD STYLESHEETS               

        // START DYNAMICALLY ADD JAVASCRIPTS
        $js = array(
            'assets/js/jquery.js',
            'assets/js/bootstrap.min.js'
        );

        $this->template->javascript->add($js);
        // END DYNAMICALLY ADD STYLESHEETS

        $this->load->model('posts_model');       

    }        

    public function index() {
            
            $this->page_view();
    }

    public function view() {

        $this->template->set_template('public/templates/default/pages_tpl');                

        $data['pages']      = $this->posts_model->get_all_posts($post_type = 'page');
        $data['page']       = $this->posts_model->get_page();

        $page_title         = $this->posts_model->get_page();

        $this->template->title = $page_title->title;                                              

        $this->template->content->view('public/templates/default/pages', $data);

        // publish the template
        $this->template->publish();     
    } 
}