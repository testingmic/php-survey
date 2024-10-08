<?php
namespace App\Controllers\v1;

use App\Controllers\AccessBridge;
use App\Controllers\Communication;
use App\Models\v1\UsersModel;

class UsersController extends AccessBridge {
    
    private $db_model;
    private $db_offset = 0;
    private $route = "users";
    private $item_table = "users";

    public $parameters;
    public $endpoint;

    // reset the query limit and offsets
    private $qr_limit;
    private $qr_offset;

    public function __construct($parameters = [])
    {
        $this->db_model = new UsersModel;
        $this->parameters = $parameters;
    }
    
    /**
     * Return all available requests for the endpoint with its accepted parameters
     * 
     * @return Array
     */
    public function index() {

        $endpoints = [];

        if( is_array($this->endpoint) ) {
            foreach($this->endpoint as $key => $value) {
                $endpoints["{$this->route}/{$key}"] = $value;
            }
        }

        return [
            'enpoints' => $endpoints
        ];
    }

    /**
     * Set the Limit and Offset Parameters
     * If the user submitted a limit then it will be applied. However, if the set limit is greater than the 
     * default value then it will be reset to the default
     * 
     * @return Mixed
     */
    private function limit_offset($params) {

        // apply the limit
        $params['_limit'] = $params['_limit'] ?? ($params['limit'] ?? $this->db_limit);
        $limit = (int) $params['_limit'];

        // set the offset
        $this->qr_limit = !empty($this->qr_limit) ? $this->qr_limit : ($limit > $this->db_limit ? $this->db_limit : $limit);

        // apply the offset
        $this->qr_offset = isset($params['offset']) ? (int) $params['offset'] : $this->db_offset;
    }

    /**
     * Get the list of all classes
     * 
     * The default to to load all records. However, when the primary_key is set then a single record is returned
     * The limit and offset filters are applied. The default limit is 100
     * 
     * @param Array     $params
     * @param Int       $primary_key
     * 
     * @return Array
     */
    public function list($params = [], $primary_key = null) {

        try {

            // apply the limit
            $this->limit_offset($params);

            // set the builder
            $builder = $this->db_model->db
                        ->table("{$this->item_table} a")
                        ->select("a.id, a.client_id, a.index_number, a.username, a.email, a.group_id,
                            a.created_by, a.avatar, a.status, a.last_login, a.date_created, a.date_updated,
                            s.name AS school_name, s.fee_payment, s.logo, s.status AS school_status,
                            s.settings AS client_settings, g.name AS group_name, a.recovercontact,
                            s.email AS school_email, s.address AS school_address
                        ")
                        ->join('clients s', 's.id = a.client_id', 'left')
                        ->join('users_groups g', 'g.id = a.group_id', 'left');

            // filter where in
            $whereInArray = $this->filterWhereIn($params, 'users');

            // loop through the filter in in array clause
            foreach($whereInArray as $key => $whereIn) {
                $builder->whereIn($key, $whereIn);
            }

            // if the primary key is set
            if(!empty($primary_key)) {
                $this->qr_limit = 1;
                $builder->where('a.id', $primary_key);
            }

            // remove the deleted record
            if( empty($params['no_grouping']) ) {
                $builder->whereNotIn('a.group_id', STUDENTGROUPID);
            }
            
            // $builder->whereNotIn('a.username', ['appuser']);
            $builder->whereNotIn('a.status', ['0']);

            // apply limit and offsets
            $builder->limit($this->qr_limit, $this->qr_offset);

            // get the data
            $result = $builder->get();

            $data = !empty($result) ? $result->getResultArray() : [];

            // set the base URL
            $rootURL = config('App')->baseURL;

            // if the loaddata was parsed and the primary key is not empty
            if( !empty($primary_key) || !empty($params['append_metadata'])) {
                // convert the item into an array
                $n_data = [];
                foreach($data as $key => $item) {
                    unset($item['password']);
                    $item['avatar'] = trim($rootURL, '/') .'/'. $item['avatar'];
                    $item['logo'] = trim($rootURL, '/') .'/'. $item['logo'];
                    $item['metadata'] = format_metadata($this->db_model->db->table('users_metadata')->where(['user_id' => $item['id'], 'client_id' => $item['client_id']])->limit(200)->get()->getResultArray());
                    $n_data = $item;
                }
                $data = $n_data;
            }

            return $data;

        } catch(\Exception $e) {
            return [];
        }
        
    }

    /**
     * Get the single user information
     * 
     * @param   Array       $params         This is set as a where clause
     * @param   Int         $unique_id      This is the unique user row id
     * @param   String      $token          This is appended to the response if not empty
     * 
     * @return Array
     */
    public function show($params = [], $unique_id = null, $token = null) {

        try {
            
            $where_clause = !empty($unique_id) ? ['a.id' => $unique_id] : $params;

            $data = $this->db_model->db->table('users a')
                                    ->select('a.*, s.name as client_name, s.fee_payment, s.logo,
                                        s.email, s.address, s.phone, s.settings, g.name AS group_name
                                    ')
                                    ->where($where_clause)
                                    ->join('clients s', 's.id = a.client_id', 'left')
                                    ->join('users_groups g', 'g.id = a.group_id', 'left')
                                    ->get(1);

            $data = !empty($data) ? $data->getResultArray() : [];
            
            // if the request is not empty
            if(!empty($data)) {
                $data = $data[0] ?? [];

                // append $token if not empty
                if( !empty($token) ) {
                    $data['access_token'] = $token;
                }

                // where clause
                $where_clause = ['user_id' => $data['id']];

                // get the client data
                $data['client'] = $this->db_model->db->table('clients')
                                        ->where(['id' => $data['client_id']])
                                        ->limit(1)->get()->getRowArray();

                // get the user metadata
                $data['metadata'] = $this->db_model->db->table('users_metadata')
                                        ->where($where_clause)
                                        ->limit(200)->get()->getResultArray();
                
                // properly format the user meta data by using name as key and setting each value
                $data['metadata'] = format_metadata($data['metadata']);

                return $data;
            }

        } catch(\Exception $e) {
            return [];
        }
        
    }

    /**
     * Update the user information
     * 
     * @param Array $params
     * 
     * @return Array
     */
    public function update($params = []) {
        
        try {

            // check if the client id is different
            if($params['client_id'] !== $params['_userData']['client_id']) {
                return 'Client id does not match';
            }

            // check if the email is already in use
            if($params['email'] !== $params['_userData']['email']) {
                
                // check if the email is already in use
                $checkEmail = $this->db_model->db->table('users')->where(['email' => $params['email']])->limit(1)->get()->getRowArray();

                // if the email is already in use
                if(!empty($checkEmail)) {
                    return 'Email already exists';
                }

                // update the email and username
                $this->db_model->db->table('users')->update(['email' => $params['email'], 'username' => $params['email']], ['user_id' => $params['id']]);
            }

            // update the name
            $this->db_model->db->table('users')->update([
                'name' => $params['name'],
            ], ['id' => $params['user_id'], 'client_id' => $params['client_id']]);

            // update the client data
            $this->db_model->db->table('clients')->update([
                'name' => $params['company'],
                'email' => $params['email'],
                'address' => $params['address'],
                'phone' => $params['phone']
            ], ['id' => $params['client_id']]);

            return ['code' => 200, 'result' => 'User updated successfully'];

        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Change the user password
     * 
     * @param Array $params
     * 
     * @return Array
     */
    public function changepassword($params = []) {

        try {

            // get the user data
            $user = $params['_userData'];

            // check if the password and confirm password is the same
            if($params['password'] !== $params['password_confirm']) {
                return 'Password and Confirm Password do not match';
            }

            // check if the password is strong enough
            if(!password_strength($params['password'])) {
                return 'Sorry! The password is not strong enough.';
            }

            // if the password is correct
            if(!password_verify($params['current_password'], $user['password'])) {
                return 'Password is incorrect';
            }

            // update the password
            $this->db_model->db->table('users')->update(['password' => password_hash($params['password'], PASSWORD_DEFAULT)], ['id' => $user['id']]);

            return [
                'code' => 200, 
                'result' => 'Password updated successfully',
                'additional' => [
                    'clear' => true
                ]
            ];

        } catch(\Exception $e) {
            return $e->getMessage();
        }

    }

}
?>