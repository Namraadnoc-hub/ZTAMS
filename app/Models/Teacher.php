<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Teacher extends Model {protected $fillable=['user_id','school_id','employee_id','full_name','phone','status']; public function user(){return $this->belongsTo(User::class);} public function school(){return $this->belongsTo(School::class);} public function assignments(){return $this->hasMany(TeacherClassAssignment::class);} public function currentAssignment(){return $this->hasOne(TeacherClassAssignment::class)->where('is_current',true);} public function timetables(){return $this->hasMany(TeacherTimetable::class);} }
