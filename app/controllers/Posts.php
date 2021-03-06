<?php
  class Posts extends Controller {

    public function __construct(){
      if(!isLoggedIn()){
        redirect('users/login');
      }
      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
    }

    public function index(){
      // get posts
      $posts = $this->postModel->getPosts();
      $data = [
        'posts' => $posts    
      ];
      $this->view('posts/index', $data);
    }

    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data =[
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => ''          
        ];

        // Validate title
        if(empty($data['title'])){
          $data['title_err'] = 'Please enter a title';
        }
        // Validate body
        if(empty($data['body'])){
          $data['body_err'] = 'Please enter a body text';
        }

        //make sure errors empty
        if(empty($data['title_err']) && empty($data['body_err'])) {
          // valid
          if($this->postModel->addPost($data)){
            flash('post_message', 'Post Added');
            redirect('posts');
          } else {
            die('Something went wrong');
          }
        } else {
          // not valid
          $this->view('posts/add', $data);
        }

      } else {
        // GET request
        $data = [
          'title' => '',
          'body' => ''
        ];

        $this->view('posts/add', $data);
      }
    }

    public function show($id){
      // get posts
      $post = $this->postModel->getPostById($id);
      $user = $this->userModel->getUserById($post->user_id);

      $data = [
        'post' => $post,
        'user' => $user    
      ];

      $this->view('posts/show', $data);
    }

    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data =[
          'id' => $id,
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => ''          
        ];

        // Validate title
        if(empty($data['title'])){
          $data['title_err'] = 'Please enter a title';
        }
        // Validate body
        if(empty($data['body'])){
          $data['body_err'] = 'Please enter a body text';
        }

        //make sure errors empty
        if(empty($data['title_err']) && empty($data['body_err'])) {
          // valid
          if($this->postModel->updatePost($data)){
            flash('post_message', 'Post updated');
            redirect('posts');
          } else {
            die('Something went wrong');
          }
        } else {
          // not valid
          $this->view('posts/edit', $data);
        }

      } else {
        // Get existing post
        $post = $this->postModel->getPostById($id);
        if($post->user_id != $_SESSION['user_id']){
          redirect('posts');
        }

        // GET request
        $data = [
          'id' => $id,
          'title' => $post->title,
          'body' => $post->body
        ];
       
        $this->view('posts/edit', $data);
      }
    }

    public function delete($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if($this->postModel->deletePost($id)){
          flash('post_message', 'Post Removed');
          redirect('posts');  
        } else {
          die('Something went wrong');
        }
      } else {
        redirect('posts');
      }
    }
  }
?>