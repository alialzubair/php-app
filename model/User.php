<?php

class User
{

    private $_db, $_data, $_session_name = '', $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = DB::getInstace();
        $this->_session_name = 'user';

        if (!$user) {
            //check the session
            if (Session::exeists($this->_session_name)) {
                $user = Session::get($this->_session_name);
                //ckeck  the user exist
                if ($this->find($user)) {
                    //user loggin successfully
                    $this->_isLoggedIn = true;
                } else {
                    //process logout

                }
            }
        } else {
            // get  the data of user
            $this->final($user);
        }
    }

    // create new user
    public function Create($fields = [])
    {
        if (!$this->_db->insert('members', $fields)) {
            throw new Exception('There was a problem ceating an account.');
        }
    }


    // find method
    public function find($user = null)
    {
        if ($user) {
            $field = (is_numeric($user) ? 'id' : 'username');
            $data = $this->_db->get('members', array($field, '=', $user));
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    // login method
    public function login($username = null, $password = null)
    {
        //find user
        $user = $this->find($username);

        if ($user) {
            if ($this->data()->password === (sha1($password))) {
                Session::put($this->_session_name, $this->data()->id);
                return true;
            }
        }
        return false;
    }
    public function data()
    {
        return $this->_data;
    }
    
    // loout method
    public function logout(){
        Session::delete($this->_session_name);
    }
    public function isLoggedIn(){
        return $this->_isLoggedIn;
    }
}
