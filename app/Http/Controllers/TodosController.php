<?php

namespace App\Http\Controllers;

use App\Todo;
use Validator;
use Carbon\Carbon;

class TodosController extends Controller
{
    public function index()
    {
    	$incompleteTodos = Todo::whereStatus(Todo::STATUS_INCOMPLETE)->orderBy('updated_at', 'desc')->get();
    	$completedTodos = Todo::whereStatus(Todo::STATUS_COMPLETED)->orderBy('completed_at', 'desc')->get();
    	$trashedTodos = Todo::onlyTrashed()->orderBy('deleted_at', 'desc')->get();

    	// \Log::debug(var_export($incompleteTodos, true));
    	// \Log::debug('completedTodos count:' . count($completedTodos));
    	// \Log::debug('deletedTodos count:' . count($deletedTodos));

    	return view('pages.todos.index', compact('incompleteTodos', 'completedTodos', 'trashedTodos'));
    }

    public function delete($id)
	{
		$todo = Todo::find($id);
		$todo->delete();
		return redirect()->route('todos.index');
	}

	public function restore($id)
	{
		$todo = Todo::onlyTrashed()->find($id);
		$todo->restore();
		return redirect()->route('todos.index');
	}

	public function ajaxUpdateTitle($id)
	{
		$todo = Todo::find($id);
		$rules = [
			'title' => 'required|min:3|max:255',
		];
		$input = request()->only(['title']);
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			foreach($validator->errors()->all() as $error){
				\Log::error($error);
			}
			return \Response::json(['result' => 'NG', 'errors' => $validator->errors()], 400);
		}
		$todo->fill([
			'title' => $input['title'],
		]);
		$todo->save();
		return \Response::json(['result' => 'OK'], 200);
	}

	public function update($id)
	{
		$todo = Todo::find($id);
		$rules = [
			'title' => 'required|min:3|max:255',
			'status' => ['required', 'numeric', 'min:1', 'max:2'],
		];
		$input = request()->only(['title', 'status']);

		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			return redirect()->route('todos.index')->withErrors($validator)->withInput();
		}

		if ($input['title'] !== null) {
			$todo->fill([
				'title' => $input['title'],
			]);
		}

		if ($input['status'] !== null) {
			\Log::debug(var_export($input, true));
			$todo->fill([
				'status' => $input['status'],
				'completed_at' => $input['status'] == Todo::STATUS_COMPLETED ? Carbon::now() : null,
			]);
		}

		$todo->save();
		return redirect()->route('todos.index');
	}

	public function store()
	{
		$rules = [
			'title' => 'required|min:3|max:255',	// 'title'は必須で3文字以上255文字以内。
		];

		$input = request()->only(['title']);
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			return redirect()->route('todos.index')->withErrors($validator)->withInput();
		}

		$todo = Todo::create([
			'title' => $input['title'],
			'status' => Todo::STATUS_INCOMPLETE,
		]);

		return redirect()->route('todos.index');
	}
}
