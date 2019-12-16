<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
	/**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('exists_encrypt', function ($attribute, $value, $parameters, $validator) {
            list($connection, $table) = explode('.', $parameters[0]);

            $field = isset($parameters[1]) ? $parameters[1] : $attribute ;

            return \DB::connection($connection)
                ->table($table)
                ->where($field, ayoencrypt($value))
                ->exists();
        });
        
        \Validator::extend('empty_refferal_code', function ($attribute, $value, $parameters, $validator) {
            if (is_null($value)==false) {
                $count = \App\Models\User\User::withTrashed()
                    ->where(function ($query) use ($parameters) {
                        $query->where('phone', ayoencrypt($parameters[0]));
                        if (is_null($parameters[1])==false) {
                            $query->orWhere('id_number', ayoencrypt($parameters[1]));
                        }
                    })
                    ->whereNotNull('refferal_code');

                if (isset($parameters[2])) {
                    $count = $count->where('id', '!=', $parameters[2]);

                    if ($user = \App\Models\User\User::find($parameters[2])) {
                        $user->update([
                            'refferal_code' => NULL
                        ]);
                    }
                }

                $count = $count->count();
                if ($count > 0) {
                    return false;
                }
            }
            return true;
        });

        \Validator::extend('id_number', function ($attribute, $value, $parameters, $validator) {
            $age = intval(date('Y', time() - strtotime($parameters[0]))) - 1970;
            if ($age >= 18) {
                $dob = date('y-m-d', strtotime($parameters[0]));
                $dob = explode("-", $dob);
                if ($parameters[1] == "female") {
                    $dob[2] = $dob[2] + 40;
                }
                $dob = $dob[2].$dob[1].$dob[0];
                $dob_nik = substr($value,6,6);
                if ($dob == $dob_nik) {
                   return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        });
        
        \Validator::extend('image_upload', function ($attribute, $value, $parameters, $validator) {
            if (in_array(\Image::make($value)->mime(), $parameters)) {
                return true;
            }
        });
        
        \Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            return \Hash::check($value, $parameters[0]);
        });
        
        \Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            // return preg_match('/^(\+62|0)[0-9]{9,13}$/', $value);
            // return preg_match('/^(\+62)[1-9]{1}[0-9]{9,13}$/', $value);
            return preg_match('/^(\+62)[0-9]{9,13}$/', $value);
        });

		\Validator::extend('unique_encrypt', function ($attribute, $value, $parameters, $validator) {
            if (in_array($attribute, ['username', 'email'])) {
                $value = strtolower($value);
            }

            list($connection, $table) = explode('.', $parameters[0]);

            $field = isset($parameters[1]) ? $parameters[1] : $attribute ;

            $query = \DB::connection($connection)
                ->table($table)
                ->where($field, ayoencrypt($value));

            if ($field == 'username') {
                $query = $query->whereNull('deleted_at');
            }

            if (isset($parameters[2]) && $parameters[2]!='NULL') {
                $primaryKey = isset($parameters[3]) ? $parameters[3] : 'id' ;
                $query->where($primaryKey, '!=', $parameters[2]);
            }

            if (count($parameters) > 4) {
                $jump = 4;
                for ($i=4; $i < (ceil((count($parameters) - 4) / 2) + 4); $i++) {
                    if (isset($parameters[$jump])) {
                        if (isset($parameters[($jump + 1)]) && $parameters[($jump + 1)]!='NULL') {
                            $paramValue = explode('|', $parameters[($jump + 1)]);
                            
                            if (count($paramValue) >= 2) :
                                $query->whereIn($parameters[$jump], $paramValue);
                            else :
                                $query->where($parameters[$jump], $parameters[($jump + 1)]);
                            endif;
                        } else {
                            $query->whereNull($parameters[$jump]);
                        }
                    }
                    $jump += 2;
                }
            }

            if ($query->count() > 0) {
                return false;
            } else {
                return true;
            }
        });

        \Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).+$/', $value);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}