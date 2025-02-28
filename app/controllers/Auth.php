<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth extends Controller {

    public function __construct()
    {
        parent::__construct();
        if(segment(2) != 'logout') {
            if(logged_in()) {
                redirect('/user/home');
            }
        }
        $this->call->library('email');
    }
	
    public function index() {
        $this->call->view('auth/login');
    }  

    public function login() {
        if ($this->form_validation->submitted()) {
            $email = $this->io->post('email');
            $password = $this->io->post('password');
            $data = $this->lauth->login($email, $password);
    
            if (empty($data)) {
                // Invalid login credentials
                $this->session->set_flashdata('err_message', 'These credentials do not match our records.');
                redirect('auth/login');
            } else {
                // Fetch user details if only ID is returned
                $user = is_array($data) ? $data : $this->lauth->get_user_details($data);
    
                if ($user) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['logged_in'] = true;
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['email'] = $user['email'];
    
                    // Check if the user is the specific one with email 'sophiadechosa12@gmail.com' and password '87654321'
                    if ($email === 'sophiadechosa12@gmail.com' && $password === '87654321') {
                        // Redirect to /admin/dashboard
                        redirect('/admin/dashboard');
                    } else {
                        // Redirect based on user role
                        $redirect_url = ($_SESSION['role'] === 'organizer') ? '/organizer/dashboard' : '/user/home';
                        redirect($redirect_url);
                    }
                } else {
                    // User not found (edge case)
                    $this->session->set_flashdata('err_message', 'User not found.');
                    redirect('auth/login');
                }
            }
        } else {
            $this->call->view('auth/login');
        }
    }
    
    
    
    

    public function register() {

        if($this->form_validation->submitted()) {
            $username = $this->io->post('username');
            $email = $this->io->post('email');
			$email_token = bin2hex(random_bytes(50));
            $this->form_validation
                ->name('username')
                    ->required()
                    ->is_unique('users', 'username', $username, 'Username was already taken.')
                    ->min_length(5, 'Username name must not be less than 5 characters.')
                    ->max_length(20, 'Username name must not be more than 20 characters.')
                    ->alpha_numeric_dash('Special characters are not allowed in username.')
                ->name('password')
                    ->required()
                    //->min_length(8, 'Password must not be less than 8 characters.')
                ->name('password_confirmation')
                    ->required()
                    //->min_length(8, 'Password confirmation name must not be less than 8 characters.')
                    ->matches('password', 'Passwords did not match.')
                ->name('email')
                    ->required()
                    ->is_unique('users', 'email', $email, 'Email was already taken.');
                if($this->form_validation->run()) {
                    if($this->lauth->register($username, $email, $this->io->post('password'), $email_token)) {
                        $data = $this->lauth->login($email, $this->io->post('password'));
                        $this->lauth->set_logged_in($data);
                        redirect('home');
                    } else {
                        set_flash_alert('danger', config_item('SQLError'));
                    }
                }  else {
                    set_flash_alert('danger', $this->form_validation->errors()); 
                    redirect('auth/register');
                }
        } else {
            $this->call->view('auth/register');
        }
        
    }

    private function send_password_token_to_email($email, $token) {
		$template = file_get_contents(ROOT_DIR.PUBLIC_DIR.'/templates/reset_password_email.html');
		$search = array('{token}', '{base_url}');
		$replace = array($token, base_url());
		$template = str_replace($search, $replace, $template);
		$this->email->recipient($email);
		$this->email->subject('Eventify Reset Password'); //change based on subject
		$this->email->sender('eventify@email.com'); //change based on sender email
		$this->email->reply_to('eventify@email.com'); // change based on sender email
		$this->email->email_content($template, 'html');
		$this->email->send();
	}

	public function password_reset() {
		if($this->form_validation->submitted()) {
			$email = $this->io->post('email');
			$this->form_validation
				->name('email')->required()->valid_email();
			if($this->form_validation->run()) {
				if($token = $this->lauth->reset_password($email)) {
					$this->send_password_token_to_email($email, $token);
                    $this->session->set_flashdata(['alert' => 'is-valid']);
				} else {
					$this->session->set_flashdata(['alert' => 'is-invalid']);
				}
			} else {
				set_flash_alert('danger', $this->form_validation->errors());
			}
		}
		$this->call->view('auth/password_reset');
	}

    public function set_new_password() {
        if($this->form_validation->submitted()) {
            $token = $this->io->post('token');
			if(isset($token) && !empty($token)) {
				$password = $this->io->post('password');
				$this->form_validation
					->name('password')
						->required()
						->min_length(8, 'New password must be atleast 8 characters.')
					->name('re_password')
						->required()
						->min_length(8, 'Retype password must be atleast 8 characters.')
						->matches('password', 'Passwords did not matched.');
						if($this->form_validation->run()) {
							if($this->lauth->reset_password_now($token, $password)) {
								set_flash_alert('success', 'Password was successfully updated.');
							} else {
								set_flash_alert('danger', config_item('SQLError'));
							}
						} else {
							set_flash_alert('danger', $this->form_validation->errors());
						}
			} else {
				set_flash_alert('danger', 'Reset token is missing.');
			}
    	redirect('auth/set-new-password/?token='.$token);
        } else {
             $token = $_GET['token'] ?? '';
            if(! $this->lauth->get_reset_password_token($token) && (! empty($token) || ! isset($token))) {
                set_flash_alert('danger', 'Invalid password reset token.');
            }
            $this->call->view('auth/new_password');
        }
		
	}

    public function logout() {
        if($this->lauth->set_logged_out()) {
            redirect('auth/login');
        }
    }

}
?>
