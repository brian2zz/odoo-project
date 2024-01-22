<?php
class DataSeeder extends CI_Controller
{
    public function user_seed()
    {
        $this->load->model('User_model');
        $data = array(
			'username' => 'admin',
			'name' => 'admin',
			'password' => password_hash('admin123', PASSWORD_DEFAULT),
			'created_at' => date('Y-m-d H:i:s'),
		);

        $this->User_model->seed_data('users',$data);
        echo 'Seeder executed successfully!';
    }
}