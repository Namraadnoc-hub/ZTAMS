<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SchoolClass extends Model {protected $table='classes'; protected $fillable=['school_id','name','grade','section','academic_year','status']; public function school(){return $this->belongsTo(School::class);} public function students(){return $this->hasMany(Student::class,'class_id');} public function assignments(){return $this->hasMany(TeacherClassAssignment::class,'class_id');} public function currentAssignment(){return $this->hasOne(TeacherClassAssignment::class,'class_id')->where('is_current',true);} public function sessions(){return $this->hasMany(AttendanceSession::class,'class_id');} }
