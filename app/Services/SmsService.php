<?php
namespace App\Services;
use App\Models\{AttendanceSession,SmsNotification,Student};
class SmsService {public function queueAbsent(AttendanceSession $session):void {$session->records()->where('status','absent')->with('student')->get()->each(function($record)use($session){$student=$record->student;if(!$student->parent_phone)return;SmsNotification::firstOrCreate(['attendance_session_id'=>$session->id,'student_id'=>$student->id],['parent_phone'=>$student->parent_phone,'message'=>"Dear Parent, your child {$student->full_name} was marked absent from school today. — Zindagi Trust",'status'=>config('services.sms.driver')==='provider'?'queued':'simulated','queued_at'=>now()]);});}}
