<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Student extends Model {protected $fillable=['school_id','class_id','student_id','full_name','parent_name','parent_phone','status']; public function school(){return $this->belongsTo(School::class);} public function schoolClass(){return $this->belongsTo(SchoolClass::class,'class_id');} public function attendanceRecords(){return $this->hasMany(AttendanceRecord::class);} }
