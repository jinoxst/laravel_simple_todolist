<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
	use SoftDeletes;
	
	const STATUS_INCOMPLETE = 1;// 未完了状態
	const STATUS_COMPLETED = 2;// 完了状態

	protected $fillable = ['title', 'status', 'completed_at'];
	protected $dates = ['completed_at', 'created_at', 'updated_at', 'deleted_at'];
}
