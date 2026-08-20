<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class AttendanceSession extends Model {protected $fillable=['school_id','class_id','teacher_id','attendance_date','status','submitted_at','locked_at']; protected function casts():array{return ['attendance_date'=>'date','submitted_at'=>'datetime','locked_at'=>'datetime'];} public function schoolClass(){return $this->belongsTo(SchoolClass::class,'class_id');} public function records(){return $this->hasMany(AttendanceRecord::class);} public function isLocked():bool{return $this->locked_at!==null || now(config('app.timezone'))->gte(Carbon::parse($this->attendance_date->format('Y-m-d').' 09:00:00',config('app.timezone')));}}
