<?php

namespace App\Controllers;

use App\Controllers\AppController;

class Home extends AppController {

    /**
     * Index Page
     * 
     * @return String
     */
    public function index() {
        
        try {

            return $this->show_display('landing');

        } catch(\Exception $e) {}

    }

    /**
     * Dashboard Page
     * 
     * @return String
     */
    public function dashboard() {
        
        try {

            // check if the user is logged in
            $this->login_check();
            
            // get the clients and web statistics list
            $data['surveys_list'] = $this->api_lookup('GET', 'surveys');

            return $this->show_display('index', $data);

        } catch(\Exception $e) {}

    }

    /**
     * Login Page
     * 
     * @return String
     */
    public function login() {
        return $this->show_display('login');
    }

    /**
     * Signup Page
     * 
     * @return String
     */
    public function signup() {
        return $this->show_display('signup');
    }

    /**
     * Not Found Page
     * 
     * @return String
     */
    public function not_found() {
        return $this->show_display('not_found');
    }

}
