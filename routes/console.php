<?php
use Illuminate\Support\Facades\Schedule;
Schedule::command('ztams:lock-attendance')->everyMinute();
