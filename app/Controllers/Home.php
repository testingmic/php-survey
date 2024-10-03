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

}
