<?php
    class Pages extends Controller{
        public function __construct(){

        }
        
        public function index(){
            if(isLoggedIn()){
                redirect('posts');
            }
            $data = [
                'title' => 'SharePosts',
                'description' => 'Simple social network buildt on a custom MVC PHP framework'
            ];

            $this->view('pages/index', $data);
        }
        
        public function about(){
            $data = [
                'title' => 'About',
                'description' => 'Created By Ilyass'
            ];
            $this->view('pages/about', $data);
        }
    }