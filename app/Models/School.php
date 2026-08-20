<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class School extends Model {protected $fillable=['name','code','address','district','status']; public function classes(){return $this->hasMany(SchoolClass::class,'school_id');} public function teachers(){return $this->hasMany(Teacher::class);} public function students(){return $this->hasMany(Student::class);} }
