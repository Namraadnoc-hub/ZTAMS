<?php
namespace App\Policies;
use App\Models\{User,SchoolClass};
class SchoolClassPolicy {public function view(User $user, SchoolClass $class):bool {if($user->hasRole('ceo')) return true;if($user->hasRole('administrator')) return $user->school_id===$class->school_id;return $user->hasRole('teacher') && $user->teacher?->currentAssignment?->class_id===$class->id;} public function update(User $user,SchoolClass $class):bool{return $this->view($user,$class);}}
