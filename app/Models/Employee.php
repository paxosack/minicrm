<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Employee
 * @package App\Models
 * @version July 30, 2020, 9:51 am UTC
 *
 * @property string $first_name
 * @property string $last_name
 * @property integer $company_id
 * @property string $email
 * @property string $phone
 */
class Employee extends Model
{
    use SoftDeletes;

    public $table = 'employees';
    

    protected $dates = ['deleted_at'];

    public $fillable = [
        'first_name',
        'last_name',
        'company_id',
        'email',
        'phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'company_id' => 'integer',
        'email' => 'string',
        'phone' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'email' => 'nullable|email',
        'company_id' => 'required'
    ];

    /**
     * Validation Messages
     *
     * @var array
     *
     */
    public static $messages = [
        'company_id.required' => 'The company field is required' // Override default as we dont want "company id filed is required."
    ];
    
    /**
     * Employees belong to a Company (required relationship)
     * 
     * @return BelongsToMany
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    
}
