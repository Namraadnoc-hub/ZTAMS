<?php

namespace App\Http\Controllers;

use App\Models\{AttendanceRecord,AttendanceSession,ClassTimetable,School,SchoolClass,Student,Teacher,TeacherClassAssignment,TeacherTimetable,User};
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PortalController extends Controller
{
    private function classStats(SchoolClass $class): array
    {
        $records = AttendanceRecord::query()->whereHas('session', fn ($q) => $q->where('class_id', $class->id));
        $total = (clone $records)->count();
        $present = (clone $records)->where('status', 'present')->count();
        $absent = (clone $records)->where('status', 'absent')->count();
        $late = (clone $records)->where('status', 'late')->count();
        return compact('total', 'present', 'absent', 'late') + ['percentage' => $total ? round((($present + $late) / $total) * 100, 1) : 0];
    }

    public function teacher(Request $request)
    {
        $teacher = $request->user()->teacher()->with('currentAssignment.schoolClass')->firstOrFail();
        $class = $teacher->currentAssignment?->schoolClass;
        abort_unless($class, 403);
        $today = $class->sessions()->whereDate('attendance_date', today(config('app.timezone')))->withCount('records')->first();
        return view('portal.teacher-dashboard', compact('teacher', 'class', 'today'));
    }

    public function students(Request $request, SchoolClass $class)
    {
        $this->authorize('view', $class);
        return view('portal.students', ['class' => $class, 'students' => $class->students()->orderBy('student_id')->paginate(30)]);
    }

    public function student(Request $request, Student $student)
    {
        $this->authorize('view', $student->schoolClass);
        $records = $student->attendanceRecords()->with('session')->latest('id')->get();
        $total = $records->count(); $present = $records->where('status','present')->count(); $absent = $records->where('status','absent')->count(); $late = $records->where('status','late')->count();
        $percentage = $total ? round((($present + $late) / $total) * 100, 1) : 0;
        return view('portal.student', compact('student','records','total','present','absent','late','percentage'));
    }

    public function timetables(Request $request, SchoolClass $class)
    {
        $this->authorize('view', $class);
        $teacher = $request->user()->teacher;
        return view('portal.timetables', ['class' => $class, 'classEntries' => ClassTimetable::where('class_id',$class->id)->orderBy('day_of_week')->orderBy('start_time')->get(), 'teacherEntries' => $teacher ? TeacherTimetable::where('teacher_id',$teacher->id)->with('schoolClass')->orderBy('day_of_week')->orderBy('start_time')->get() : collect()]);
    }

    public function saveTimetable(Request $request, SchoolClass $class)
    {
        $this->authorize('update', $class);
        $data=$request->validate(['day_of_week'=>'required|integer|between:1,7','start_time'=>'required','end_time'=>'required','subject'=>'required|string|max:100','room'=>'nullable|string|max:100']);
        ClassTimetable::updateOrCreate(['class_id'=>$class->id,'day_of_week'=>$data['day_of_week'],'start_time'=>$data['start_time']], $data + ['teacher_id'=>$request->user()->teacher?->id]);
        app(AuditService::class)->record($request->user(),'timetable_updated',$class);
        return back()->with('success','Timetable saved.');
    }

    public function admin(Request $request)
    {
        $schoolId=$request->user()->school_id;
        $classes=SchoolClass::where('school_id',$schoolId)->with('currentAssignment.teacher')->withCount('students')->get();
        $todaySessions=AttendanceSession::where('school_id',$schoolId)->whereDate('attendance_date',today(config('app.timezone')))->get();
        return view('portal.admin-dashboard', compact('classes','todaySessions'));
    }

    public function adminClass(Request $request, SchoolClass $class)
    {
        abort_unless($request->user()->school_id === $class->school_id,403);
        return view('portal.class-detail',['class'=>$class->load('students','currentAssignment.teacher'),'stats'=>$this->classStats($class),'sessions'=>$class->sessions()->latest('attendance_date')->withCount('records')->take(10)->get()]);
    }

    public function teachers(Request $request)
    {
        $teachers=Teacher::where('school_id',$request->user()->school_id)->with('currentAssignment.schoolClass')->get();
        return view('portal.teachers',compact('teachers'));
    }

    public function createTeacher(Request $request)
    {
        $data=$request->validate(['full_name'=>'required|string|max:120','email'=>'required|email|unique:users,email','employee_id'=>'required|string|max:50','class_id'=>'required|exists:classes,id']);
        $class=SchoolClass::findOrFail($data['class_id']); abort_unless($class->school_id===$request->user()->school_id,403);
        $temporary=substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'),0,10);
        DB::transaction(function()use($data,$class,$temporary,$request){$user=User::create(['school_id'=>$class->school_id,'name'=>$data['full_name'],'email'=>$data['email'],'role'=>'teacher','password'=>Hash::make($temporary)]);$teacher=Teacher::create(['user_id'=>$user->id,'school_id'=>$class->school_id,'employee_id'=>$data['employee_id'],'full_name'=>$data['full_name'],'status'=>'active']);TeacherClassAssignment::where('class_id',$class->id)->where('is_current',true)->update(['is_current'=>false,'end_date'=>today()]);TeacherClassAssignment::create(['teacher_id'=>$teacher->id,'class_id'=>$class->id,'start_date'=>today(),'is_current'=>true]);app(AuditService::class)->record($request->user(),'teacher_created',$teacher);});
        return back()->with('success',"Teacher created. Temporary password (show once): {$temporary}");
    }

    public function ceo()
    {
        $schools=School::withCount(['classes','students','teachers'])->get();
        $records=AttendanceRecord::query();$total=$records->count();$present=(clone $records)->whereIn('status',['present','late'])->count();
        return view('portal.ceo-dashboard',compact('schools','total','present'));
    }

    public function school(School $school){return view('portal.school',['school'=>$school,'classes'=>$school->classes()->with('currentAssignment.teacher')->withCount('students')->get()]);}
    public function ceoClass(SchoolClass $class){return view('portal.class-detail',['class'=>$class->load('students','currentAssignment.teacher'),'stats'=>$this->classStats($class),'sessions'=>$class->sessions()->latest('attendance_date')->withCount('records')->take(10)->get()]);}

    public function report(Request $request)
    {
        $query=AttendanceRecord::with(['student.schoolClass','session']);
        if($request->user()->hasRole('teacher')) $query->whereHas('student',fn($q)=>$q->where('class_id',$request->user()->teacher?->currentAssignment?->class_id));
        elseif($request->user()->hasRole('administrator')) $query->whereHas('student',fn($q)=>$q->where('school_id',$request->user()->school_id));
        return view('portal.report',['records'=>$query->latest('id')->paginate(100)]);
    }
    public function csv(Request $request)
    {
        $query=AttendanceRecord::with(['student.schoolClass','session']); if($request->user()->hasRole('teacher'))$query->whereHas('student',fn($q)=>$q->where('class_id',$request->user()->teacher?->currentAssignment?->class_id));elseif($request->user()->hasRole('administrator'))$query->whereHas('student',fn($q)=>$q->where('school_id',$request->user()->school_id));
        app(AuditService::class)->record($request->user(),'report_exported',(object)['id'=>null]);
        return response()->streamDownload(function()use($query){$out=fopen('php://output','w');fputcsv($out,['Date','Class','Student ID','Student','Status']);$query->chunk(250,function($rows)use($out){foreach($rows as $r)fputcsv($out,[$r->session->attendance_date,$r->student->schoolClass->name,$r->student->student_id,$r->student->full_name,$r->status]);});fclose($out);},'ztams-attendance.csv',['Content-Type'=>'text/csv']);
    }
}
