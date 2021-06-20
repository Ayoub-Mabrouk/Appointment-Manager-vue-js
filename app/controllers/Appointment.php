<?php
class Appointment extends Controller
{
    public function __construct()
    {
        $this->AppointmentModel = $this->model('AppointmentModel');
    }
    public function myappointments()
    {
        try {
            if (!!$this->verifytoken($this->gettoken())) {
                print_r(json_encode($this->AppointmentModel->myAppointments($this->verifytoken($this->gettoken()))));
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function searchbyday()
    { 
        
        try {
            if (!!$this->verifytoken($this->gettoken())) {
                // $dates = array_fill(0, 4,'false');
                $dates = array('08-10'=>'false','10-12'=>'false','14-16'=>'false','16-18'=>'false');
                $reserved = $this->AppointmentModel->searchByDay($this->data->a_date);
                // die(print_r(json_encode($dates)));
                if (count(array_filter($reserved))) {
                    foreach ($reserved as $date) {
                        $time = date("H", strtotime($date->a_date));
                        switch (true) {
                            case ($time >= 8 && $time < 10):
                                $dates['08-10'] = 'true';
                                break;
                            case ($time >= 10 && $time < 12):
                                $dates['10-12'] = 'true';
                                break;
                            case ($time >= 14 && $time < 16):
                                $dates['14-16'] = 'true';
                                break;
                            case ($time >= 16 && $time < 18):
                                $dates['16-18'] = 'true';
                                break;
                        }
                    }
                }
                print_r(json_encode($dates));
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function reserve(){
        try {
            if (!!$this->verifytoken($this->gettoken())) {
                
                print_r(json_encode($this->AppointmentModel->reserve($this->verifytoken($this->gettoken()),$this->data->a_date)));
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        
    }
    public function cancel_appointment(){
        try {
            if (!!$this->verifytoken($this->gettoken())) {
                
                print_r(json_encode($this->AppointmentModel->cancel_appointment($this->verifytoken($this->gettoken()),$this->data->a_id)));
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }       
    }
    public function edit_appointment(){
        try {
            if (!!$this->verifytoken($this->gettoken())) {
                print_r(json_encode($this->AppointmentModel->edit_appointment($this->verifytoken($this->gettoken()),$this->data->a_id,$this->data->a_date)));
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }    
    }
}
