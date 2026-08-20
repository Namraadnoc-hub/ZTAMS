<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TeacherClassAssignment extends Model {protected $fillable=['teacher_id','class_id','start_date','end_date','is_current']; protected function casts():array{return ['start_date'=>'date','end_date'=>'date','is_current'=>'boolean'];} public function teacher(){return $this->belongsTo(Teacher::class);} public function schoolClass(){return $this->belongsTo(SchoolClass::class,'class_id');} }
