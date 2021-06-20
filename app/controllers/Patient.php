<?php
class Patient extends Controller
{
    public function __construct()
    {
        $this->PatientModel = $this->model('PatientModel');
    }
    public function register()
    {
        $register = $this->PatientModel->register($this->data->firstname, $this->data->lastname, $this->reference_generator(), $this->data->email, $this->data->password);
        print_r(json_encode($register));
    }
    public function reference_generator()
    {
        return $this->data->firstname[0] . $this->data->lastname[0] . uniqid() . time() . $this->data->firstname[1] . $this->data->lastname[1];
    }
    public function login()
    {
        $user = $this->PatientModel->login($this->data->email, $this->data->password);
        if ($user['status'] == true) {
            $token = $this->authorization($user['data']->p_id);
            print_r(json_encode(array(
                'user' => $user['status'],
                'token' => $token,
                'data' => $user['data']
            )));
        } else {
            print_r(json_encode($user['status']));
        }
    }
    public function loginbyreference(){
        $user = $this->PatientModel->loginByReference($this->data->p_reference);
        if ($user['status'] == true) {
            $token = $this->authorization($user['data']->p_id);
            print_r(json_encode(array(
                'user' => $user['status'],
                'token' => $token,
                'data' => $user['data']
            )));
        } else {
            print_r(json_encode($user['status']));
        }
    }
    public function check_expiration()
    {
        try {
            if (!!$this->verifytoken($this->gettoken())) {
                echo(json_encode($this->verifytoken($this->gettoken())));
            }
        } catch (\Throwable $th) {
            echo json_encode("false");
        }
    }
    
}
