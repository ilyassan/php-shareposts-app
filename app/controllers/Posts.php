<?php
    class Posts extends Controller{
        public function __construct(){
            if(!isLoggedIn()){
                redirect('users/login');
            }

            $this->postModel = $this->model('Post');
        }

        public function index(){
            //  Get posts
            $posts = $this->postModel->getPosts();

            $data = [
                'posts' => $posts
            ];

            $this->view('posts/index', $data);
        }

        public function add(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate data
                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title';
                }
                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body text';
                }

                // Make sure errors are empty (There's no errors)
                if(empty($data['title_err']) && empty($data['body_err'])){
                    // Validate
                    if($this->postModel->addPost($data)){
                        flash('post_message', 'Post Added');
                        redirect('posts');
                    }else{
                        die('Something went wrong');
                    }
                }else{
                    // Load view with errors
                    $this->view('posts/add', $data);
                }

            }else{
                $data = [
                    'title' => '',
                    'body' => ''
                ];
    
                $this->view('posts/add', $data);
            }
        }

        public function edit($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'id' => $id,
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate data
                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title';
                }
                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body text';
                }

                // Make sure errors are empty (There's no errors)
                if(empty($data['title_err']) && empty($data['body_err'])){
                    // Validate
                    if($this->postModel->updatePost($data)){
                        flash('post_message', 'Post Updated');
                        redirect('posts');
                    }else{
                        die('Something went wrong');
                    }
                }else{
                    // Load view with errors
                    $this->view('posts/edit', $data);
                }

            }else{
                // Get existing post from model
                $post = $this->postModel->getPostById($id);

                $this->checkPostExist($post);

                // Check for owner
                if($post->user_id != $_SESSION['user_id']){
                    redirect('posts');
                }

                $data = [
                    'id' => $id,
                    'title' => $post->title,
                    'body' => $post->body
                ];
    
                $this->view('posts/edit', $data);
            }
        }

        public function show($id){
            // Get existing post from model
            $post = $this->postModel->getPostById($id);

            $this->checkPostExist($post);

            $data = [
                'post' => $post
            ];

            $this->view('posts/show', $data);
        }

        public function delete($id){
            
            // Check for method and owner
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Get existing post from model
                $post = $this->postModel->getPostById($id);
                
                $this->checkPostExist($post);

                if( $post->user_id == $_SESSION['user_id']){
                    if($this->postModel->deletePost($id)){
                        flash('post_message', 'Post deleted');
                        redirect('posts');
                    }else{
                        die('Something went wrong');
                    }
                }
            }else{
                redirect('posts');
            }
        }

        public function checkPostExist($post){
            // if there's no data
            if(!$post){
                redirect('posts');
            }
        }
    }