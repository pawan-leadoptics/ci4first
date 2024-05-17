<?php
namespace App\Controllers;

use App\Models\UserModel;


class Home extends BaseController
{
    // Home view -----
    public function index(): string
    {
        return view('index');
    }
    //registration page view---------
    public function register(): string
    {
        return view('/pages/registration');
    }

    //Error page ---------->
    public function errPage()
    {
        return view('/pages/error-page');
    }

    // auth page----------> 
    public function authenticateUserPage(string $token)
    {
        $userModel = new UserModel();

        $uri = service('uri');
        $code = $uri->getSegment(2);
        $data = $userModel->where('Token', $code)->first();
        if (empty($data['Token'])) {
            return redirect('error')->with('status', 'This link is expired');
        }

        return view('/pages/auth-user-page', ['code' => $code]);
    }

    //profile page view--------- 
    public function profile()
    {
        $session = session();
        if ($session->has('isLoggedIn') && $session->get('isLoggedIn') === true) {
            $userData = [
                'name' => $session->get('FirstName'),
                'lastname' => $session->get('LastName'),
                'number' => $session->get('MobileNumber'),
                'email' => $session->get('Email'),
            ];
            if ($userData) {
                return view('/pages/profile', ['userData' => $userData]);
            } else {
                return redirect()->to('/')->with('error', 'User data not found.');
            }
        } else {
            return redirect()->to('/');
        }
    } 

    //data store in db---------
    public function storeData()
    {
        date_default_timezone_set('Asia/Kolkata');
        $currentDateTime = date("Y/m/d/h:i:sa"); 
        $session = session(); 
        $token = uniqid();
        $session->set('token', $token); 
        $userModel = new UserModel(); 
        $userData = [
            'FirstName' => $this->request->getPost('name'),
            'LastName' => $this->request->getPost('lastname'),
            'MobileNumber' => $this->request->getPost('number'),
            'Email' => $this->request->getPost('email'),
            'Password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'Verified' => 0,
            'Token' => $token,
            'date_time' => $currentDateTime,
        ];
        $userEmail = $this->request->getPost('email');
        $session->set('userEmail', $userEmail);

        $existingUser = $userModel->where('Email', $userEmail)->first();
        if ($existingUser) {
            $session->setFlashdata('msg', 'Email already exists.');
            return redirect()->to('home/register');
        }

        $email = \Config\Services::email();

        $email->setFrom('myelyte1@gmail.com', 'Verify Your Account ');
        $email->setTo($userEmail);

        $email->setSubject('Account Verification');
        $email->setMessage("
        <div style='max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
            <h2>Email Activation</h2>
            <p>Thank you for registering with us. Please click the button below to activate your account:</p>
            <a href='" . base_url('authentication/' . $token) . "' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 20px;'>Activate Account</a>
            <p style='margin-top: 20px;'>If you received this email by mistake, please ignore it.</p>
        </div>
    ");

        $email->send();


        $userModel->save($userData);
        return redirect('/')->with('status', 'We have sand an activation email to your email address');
    }

    //authendicate user---------

    public function loginAuth()
    { 
        $session = session();  
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $data = $userModel->where('Email', $email)->first();

        if ($email == "" || $password == "") {
            $session->setFlashdata('msg', 'Please fill the form first');
            return redirect()->to('/');
        }
        if ($data === null) {
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/');
        }

        $Verified = $data['Verified'];
        if ($Verified == 0) {
            $session->setFlashdata('msg', 'Please verify your account');
            return redirect()->to('/');
        } else {


            if ($data) {
                $pass = $data['Password'];
                $authenticatePassword = password_verify($password, $pass);
                if ($authenticatePassword) {
                    $ses_data = [
                        'FirstName' => $data['FirstName'],
                        'LastName' => $data['LastName'],
                        'MobileNumber' => $data['MobileNumber'],
                        'Email' => $data['Email'],
                        'isLoggedIn' => TRUE
                    ];
                    $session->set($ses_data);
                    return redirect()->to('/home/profile');

                } else {
                    $session->setFlashdata('msg', 'Email or Password are incorrect.');
                    return redirect()->to('/');
                }
            } else {
                $session->setFlashdata('msg', 'Email does not exist.');
                return redirect()->to('/');
            }
        }
    }

    // logout and session destroy --------
    public function logout()
    {
        if ($this->request->getMethod() === 'post' && $this->request->getPost('logout')) {
            $session = session();
            $session->destroy();
            return redirect()->to('/');
        }
    }

    // authenticate user for url------------
    public function authUser()
    {
        $uri = service('uri');
        $code = $uri->getSegment(2);
        echo $code;
        $userModel = new UserModel();
        $data = $userModel->where('Token', $code)->first();
        if ($data && $data['Token'] == $code) {
            $userModel->update($data['UserID'], [
                'Verified' => 1,
                'Token' => ''
            ]);
            return redirect('error')->with('status', 'Activation Successful');
        } else if (!$data) {
            return redirect('/')->with('status', 'Your account is already activated.');
        } else {
            return redirect('error')->with('status', 'Something went wrong, please try-again.');

        }
    }

}
