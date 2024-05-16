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
    public function authenticateUserPage(string $token): string
    {
        // $userModel = new UserModel();
        $session = session();
        $userEmail = $session->get('userEmail');
        // $dbToken = $session->get('token');
        // $data = $userModel->where('Token', $dbToken)->first();
        // if ($data) {
        //     return view('index');
        // }

        return view('/pages/auth-user-page', ['userEmail' => $userEmail]);
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
    // not working ----

    //dota store in db---------

    public function storeData()
    {
        $session = session();

        $token = uniqid();
        $session->set('token', $token);


        $userModel = new UserModel();
        $EmailVerificationKey = mt_rand(10000, 99999);
        $session->set('EmailVerificationKey', $EmailVerificationKey);
        // $setToken = $session->get('token');


        $userData = [
            'FirstName' => $this->request->getPost('name'),
            'LastName' => $this->request->getPost('lastname'),
            'MobileNumber' => $this->request->getPost('number'),
            'Email' => $this->request->getPost('email'),
            'Password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'Verified' => 0,
            'Token' => $token,
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
        <div >
        <div style=' padding: 10px;'>
            Please verify your account
        </div>
        <div style=' padding: 10px;'>
            <a href='" . base_url('home/authenticateUserPage/' . $token) . "' style='display: inline-block; padding: 10px 20px; color: #ffffff; background-color: #007bff; border-radius: 5px; text-decoration: none;'>Click Here</a>
        </div>
        <div class='text-primary ' style='padding: 10px;'>verification code: $EmailVerificationKey</div>
        </div>
        ");

        $email->send();


        $userModel->save($userData);
        return redirect('/')->with('status', 'We have sand verification email to your email id');
    }

    //authendicate user---------

    public function loginAuth()
    {
        // $prefix = 'token_';
        // $token = uniqid($prefix);
        // echo $token;
        // exit;
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

    public function authUser()
    {
        $session = session();
        $emailVerificationKey = $session->get('EmailVerificationKey');


        $userModel = new UserModel();
        $email = $this->request->getPost('authemail');
        $authUser = $this->request->getPost('authCode');
        $data = $userModel->where('Email', $email)->first();


        if ($email && $authUser == $emailVerificationKey) {
            if ($data) {
                $data['Verified'] = 1;
                $userModel->verificationStatus($data);
                return redirect('/')->with('status', 'Authentication Successful');
            } else {
                return redirect('/')->with('status', 'Failed to login, Please re-register');

            }
        } else {
            if ($data) {
                $userModel->deleteUserByEmailInAuthPage($email);
                return redirect('/')->with('status', 'Failed to login, Please re-register');
            } else {
                return redirect('/')->with('status', 'Failed to login, Please try again');
            }
        }
    }

}
