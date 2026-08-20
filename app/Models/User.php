<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable { use Notifiable; protected $fillable=['school_id','name','email','role','password']; protected $hidden=['password','remember_token']; protected function casts(): array{return ['email_verified_at'=>'datetime','password'=>'hashed'];} public function school(){return $this->belongsTo(School::class);} public function teacher(){return $this->hasOne(Teacher::class);} public function hasRole(string $role): bool{return $this->role===$role;} }
