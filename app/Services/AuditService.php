<?php
namespace App\Services;
use App\Models\AuditLog; use App\Models\User;
class AuditService {public function record(?User $user,string $action,object $entity,array $metadata=[]):void {AuditLog::create(['user_id'=>$user?->id,'action'=>$action,'entity'=>class_basename($entity),'entity_id'=>$entity->id ?? null,'metadata'=>$metadata]);}}
