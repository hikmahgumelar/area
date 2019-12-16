<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $data, $error = "";
    protected function show_success($success, $code = "")
    {
        $return_value = array(
            'status'            => TRUE,
            'message'           => $success,
            'data'              => $this->data
        );
        $status_code = $code ? $code : 200;
        return response()->json($return_value, $status_code);
    }

    protected function show_error($errors = '', $code = "")
    {
        $errors = trim($errors);
        if ( ! empty($errors)) {
            $return_value =
                array(
                    'status'    => FALSE,
                    'message'     => $errors,
                    'data'     => $this->data
                );
        }else {
            $return_value =
                array(
                    'status' => FALSE,
                    'message' => 'Unknown errors.',
                    'data'     => $this->data
                );
        }
        $status_code = $code ? $code : 400;
        return response()->json($return_value, $status_code);
    }

    protected function response($data, $code = "")
    {
        if ($data){
            $return_value = array(
                'status'            => TRUE,
                'message'           => "success",
                'data'              => $data
            );
            $status_code = $code ? $code : 200;
        }else{
            $return_value = array(
                'status'            => FALSE,
                'message'           => "error",
                'error'             => $this->error
            );
            $status_code = $code ? $code : 400;
        }

        return response()->json($return_value, $status_code);
    }

    protected function show_error_validation($errors = array(), $code = "")
    {
        $return_value =
            array(
                'status'    => FALSE,
                'message'     => $errors,
                'data'     => $this->data
            );
        return response()->json($return_value, 422);
    }
}
