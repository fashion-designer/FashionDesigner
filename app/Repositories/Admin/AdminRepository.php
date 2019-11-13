<?php namespace App\Repositories\Admin;

use App\Admin;
use App\Models\Gender\Gender;

/**
 * Class AdminRepository
 * @package App\Repositories\Admin
 */
class AdminRepository
{
    /**
     * Model
     *
     * @var Admin
     */
    public $model;
    /**
     * AdminRepository constructor.
     */
    public function __construct()
    {
        $this->model = new Admin();
    }

    /**
     * Get Admins List
     *
     * @return Admin[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        $list = $this->model->with(['getGender'])->get();

        return $list;
    }

    /**
     * @param int $id
     * @return Admin[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAdminProfile($id)
    {
        $profile = $this->model->where('id', $id)->with(['getGender'])->get();

        return $profile;
    }

    /**
     * @param int $id
     * @param array $input
     * @return bool
     */
    public function updateAdminProfile($id, $input)
    {
        if(!array_key_exists('is_active', $input))
        {
            $input['is_active'] = 0;
        }
        else
        {
            $input['is_active'] = 1;
        }

        if(!array_key_exists('is_verified', $input))
        {
            $input['is_verified'] = 0;
        }
        else
        {
            $input['is_verified'] = 1;
        }

        unset($input['_token']);

        return $this->model->where('id', $id)->update($input);
    }

    /**
     * @param $input
     * @return Admin|\Illuminate\Database\Eloquent\Model
     */
    public function save($input)
    {
        if(!array_key_exists('is_active', $input))
        {
            $input['is_active'] = 0;
        }
        else
        {
            $input['is_active'] = 1;
        }

        if(!array_key_exists('is_verified', $input))
        {
            $input['is_verified'] = 0;
        }
        else
        {
            $input['is_verified'] = 1;
        }

        return $this->model->create($input);
    }

    /**
     * @return Admin|mixed
     */
    public function getProfile()
    {
        $id = auth('admin')->id();

        $data = $this->model->where('id', $id)->get();

        return $data[0];
    }

    /**
     * @param array $input
     * @return bool
     */
    public function updateProfile($input)
    {
        $id = auth('admin')->id();

        if(!array_key_exists('is_active', $input))
        {
            $input['is_active'] = 0;
        }
        else
        {
            $input['is_active'] = 1;
        }

        if(!array_key_exists('is_verified', $input))
        {
            $input['is_verified'] = 0;
        }
        else
        {
            $input['is_verified'] = 1;
        }

        unset($input['_token']);
        unset($input['password']);

        return $this->model->where('id', $id)->update($input);
    }

    /**
     * Get All Genders
     *
     * @return Gender[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllGenders()
    {
        return (new Gender())->get(['id', 'name']);
    }
}