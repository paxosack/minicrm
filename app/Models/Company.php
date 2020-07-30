<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Company
 * @package App\Models
 * @version July 30, 2020, 9:47 am UTC
 *
 * @property string $Name
 * @property string $email
 * @property integer $logo_id
 * @property string $website
 */
class Company extends Model
{
    use SoftDeletes,CascadeSoftDeletes;

    protected $cascadeDeletes = ['employees'];
    
    public $table = 'companies';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'email',
        'logo',
        'website'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'logo' => 'string',
        'website' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'nullable|email|max:255',
        'website' => 'max:255',
        'logo_file'  => 'file|dimensions:min_width=100,min_height=100',
    ];

    /**
     * Validation Messages
     * 
     * @var array
     * 
     */
    public static $messages = [];
    
    /**
     * Company may have multiple Employees
     *
     * @return HasMany
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    
}
