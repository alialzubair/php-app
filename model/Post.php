<?php

class Post {
    static function get(){
      $post=DB::getInstace()->all('categories');
      return $post;
    }
    static function single($id){
      $post=DB::getInstace()->get('categories',['id','=',$id]);
      return $post;
    }
    // add new category
  static function create($data=[])
  {
    $cat = DB::getInstace()->insert('categories', $data);
  }
    // edit new category
  static function Edit($id,$data=[])
  {
    $cat = DB::getInstace()->update('categories',$id,'id', $data);
  }
    // delete new category
  static function Delete($id)
  {
    $cat = DB::getInstace()->delete('categories',['id','=',$id]);
    if($cat){
      return true;
    }
    else{
      return false;
    }
  }


}