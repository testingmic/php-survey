<?php

namespace App\Controllers;

use App\Controllers\AppController;

class Pages extends AppController {

    /**
     * Account Page
     * 
     * @return String
     */
    public function account() {
        // check if the user is logged in
        $this->login_check();

        // get the user data
        return $this->show_display('account');
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
