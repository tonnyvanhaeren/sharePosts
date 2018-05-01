<?php

  class Post {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getPosts(){
      $this->db->query('SELECT *,
                        posts.id as postId,
                        users.id as userId,
                        posts.created_at as postCreated,
                        users.created_at as userCreated
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        ORDER BY posts.created_at DESC
                         ');
      $results =  $this->db->resultSet();
      return $results;
    }

    public function addPost($data){
      $this->db->query('INSERT INTO posts (title, body, user_id) VALUES(:title, :body, :user_id) ');
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':user_id', $data['user_id']);


      if($this->db->execute()){
        return true;
      } else {
        return false;
      }

    }

    public function getPostById($id){
      $this->db->query('SELECT * FROM posts WHERE id = :id ');
      $this->db->bind(':id', $id);

      $post =  $this->db->single();
      return $post;
    }

    public function updatePost($data){
      $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);

      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function deletePost($id){
      // check current user
      $post = $this->getPostById($id);

      if($post->user_id != $_SESSION['user_id']){
        redirect('posts');
      }

      $this->db->query('DELETE FROM posts WHERE id = :id');
      $this->db->bind(':id', $id);

      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }
?>