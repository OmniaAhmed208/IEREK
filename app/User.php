<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function countries()
    {
        return $this->hasOne('App\Models\Countries', 'country_id', 'country_id');
    }
    public function user_types()
    {
        return $this->hasOne('App\Models\UserType', 'user_type_id', 'user_type_id');
    }
    public function user_titles()
    {
        return $this->hasOne('App\Models\Titles', 'user_title_id', 'user_title_id');
    }


    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'user_title_id', 'country_id', 'phone', 'age', 'gender', 'image'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}