<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><h1>Assalam-o-Alaikum, <?php echo e($teacher->full_name); ?> 👋</h1><p class="muted"><?php echo e(now(config('app.timezone'))->format('l, d F Y')); ?></p><div class="card"><h2><?php echo e($class->name); ?></h2><p>30 students · Your assigned class</p><p><span class="badge"><?php echo e($today?->status ?? 'Not started'); ?></span> <?php if($today?->isLocked()): ?> Attendance locked at 9:00 AM. <?php else: ?> Attendance can be edited until 9:00 AM. <?php endif; ?></p><a class="btn" href="<?php echo e(route('teacher.attendance.show',$class)); ?>">Take Attendance</a></div><div class="grid"><div class="card"><h3>My Students</h3><a class="btn alt" href="<?php echo e(route('teacher.students',$class)); ?>">View performance</a></div><div class="card"><h3>Timetables</h3><a class="btn alt" href="<?php echo e(route('teacher.timetables',$class)); ?>">View schedules</a></div></div> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Namara saleem\Documents\Codex\2026-08-16\jh\ztams\resources\views/portal/teacher-dashboard.blade.php ENDPATH**/ ?>