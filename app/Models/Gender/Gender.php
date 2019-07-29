<?php namespace App\Models\Gender;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Gender
 * @package App\Models\Gender
 */
class Gender extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'genders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}