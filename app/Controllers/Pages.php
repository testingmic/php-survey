<?php

namespace App\Controllers;

use App\Controllers\AppController;
use App\Models\v1\SurveyModel;

class Pages extends AppController {

    /**
     * Page
     * 
     * @param String $page
     * 
     * @return String
     */
    public function page($page, $path = 'account') {
        
        // check if the user is logged in
        $this->login_check();

        // get the survey model
        $dbObject = new SurveyModel();

        // page check
        $data['page'] = $page;

        // pages
        $data['pages'] = [
            'account' => 'Account Summary',
            'billing' => 'Billing',
            'transaction' => 'Transactions'
        ];

        // login history
        if($path === 'login_history') {
            $data['login_history'] = $dbObject->db->table('login_history')
                                            ->where(['user_id' => $this->sessObject->_userId])
                                            ->orderBy('lastlogin', 'DESC')
                                            ->get()->getResultArray();
        }

        // set the path to use
        $data['path'] = $path;

        // get the user data
        return $this->show_display($page, $data);
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
