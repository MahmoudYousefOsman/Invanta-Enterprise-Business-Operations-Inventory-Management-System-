<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EngineerRequest;
use App\Models\Engineer;
use App\Models\Product;
use App\Models\Task;
use Illuminate\Http\Request;
use App\DataTables\EngineerDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Flasher\Notyf\Prime\NotyfInterface;


class EngineerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EngineerDataTable $dataTable)
    {
        return $dataTable->render('admin.engineers.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.engineers.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(EngineerRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        Engineer::create($data);

        notyf()->addSuccess('تم إضافة المهندس بنجاح');
        return redirect()->route('admin.engineers.index');
    }


    public function update(EngineerRequest $request, Engineer $engineer)
    {
        if (!Hash::check($request->password, $engineer->password)) {
            return back()->withErrors(['password' => 'كلمة المرور الحالية غير صحيحة'])->withInput();
        }
        $data = $request->validated();

        if (!empty($data['new_password'])) {
            $data['password'] = Hash::make($data['new_password']);
        }else{
            unset($data['password']);

        }
        unset($data['new_password']);
        $engineer->update($data);

        notyf()->addSuccess('تم تعديل المهندس بنجاح');
        return redirect()->route('admin.engineers.index');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Engineer $engineer)
    {
        return view('admin.engineers.edit', compact('engineer'));
    }

    public function show(Engineer $engineer)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Engineer $engineer)
    {
        $engineer->delete();
        \Flasher\Notyf\Prime\notyf()->addSuccess('تم حذف المهندس بنجاح');
        return redirect()->route('admin.engineers.index');
    }

    public function engineerTasks()
    {
        $engineer_id = Auth::guard('engineer')->id();
        $tasksNew = Task::where('status', 'new')->where('engineer_id', $engineer_id)->orderBy('created_at', 'desc')->get();
        $tasksPending = Task::where('status', 'completed')->where('engineer_id', $engineer_id)->orderBy('created_at', 'desc')->get();
        $tasksCancelled = Task::where('status', 'cancelled')->where('engineer_id', $engineer_id)->orderBy('created_at', 'desc')->get();
        return view('admin.engineers.engineer_tasks', compact('tasksNew', 'tasksPending', 'tasksCancelled'));
    }

    public function engineerTaskDetails(Task $task)
    {
        $products = Product::where('type','fix')->get();
        $task->load('client', 'engineer', 'products');
        return view('admin.engineers.engineer_task_details', compact('task', 'products'));
    }

    public function account()
    {
        $engineer = Auth::guard('engineer')->user();
        $engineer->load('tasks');
        $monthlyTasks = $engineer->tasks()
            ->whereMonth('receipt_date', now()->month)
            ->whereYear('receipt_date', now()->year)
            ->get();
        $monthlyTotal = $monthlyTasks
            ->where('status', 'completed')
            ->sum(function ($task) {
                return $task->commission_pound;
            });
        return view('admin.engineers.account', compact('engineer', 'monthlyTasks', 'monthlyTotal'));
    }
    public function engineer_transactions(Request $request)
    {
        $engineers = Engineer::all();

        $tasks = Task::with(['engineer', 'client'])
            ->when($request->engineer_id, function ($query) use ($request) {
                $query->where('engineer_id', $request->engineer_id);
            })
            ->when($request->date_from, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->date_to);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.engineers.engineer_transactions', compact('engineers', 'tasks'));
    }


}
