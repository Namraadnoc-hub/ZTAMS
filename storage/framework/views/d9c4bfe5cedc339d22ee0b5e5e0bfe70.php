<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><h1><?php echo e($class->name); ?> Timetables</h1><h2>Class timetable</h2><table><tr><th>Day</th><th>Time</th><th>Subject</th><th>Room</th></tr><?php $__currentLoopData = $classEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e(['','Mon','Tue','Wed','Thu','Fri','Sat','Sun'][$entry->day_of_week]); ?></td><td><?php echo e(substr($entry->start_time,0,5)); ?>–<?php echo e(substr($entry->end_time,0,5)); ?></td><td><?php echo e($entry->subject); ?></td><td><?php echo e($entry->room); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></table><h2>My teaching timetable</h2><table><tr><th>Day</th><th>Time</th><th>Class</th><th>Subject</th></tr><?php $__currentLoopData = $teacherEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e(['','Mon','Tue','Wed','Thu','Fri','Sat','Sun'][$entry->day_of_week]); ?></td><td><?php echo e(substr($entry->start_time,0,5)); ?></td><td><?php echo e($entry->schoolClass->name); ?></td><td><?php echo e($entry->subject); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></table><button class="no-print" onclick="print()">Print timetable</button> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Namara saleem\Documents\Codex\2026-08-16\jh\ztams\resources\views/portal/timetables.blade.php ENDPATH**/ ?>