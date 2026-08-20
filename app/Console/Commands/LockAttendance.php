<?php
namespace App\Console\Commands;
use App\Models\AttendanceSession; use Illuminate\Console\Command;
class LockAttendance extends Command {protected $signature='ztams:lock-attendance';protected $description='Lock daily attendance at the configured server-side cutoff';public function handle():int {AttendanceSession::whereDate('attendance_date',today(config('app.timezone')))->whereNull('locked_at')->whereTime('created_at','<=','09:00:00')->update(['status'=>'locked','locked_at'=>now()]);return self::SUCCESS;}}
