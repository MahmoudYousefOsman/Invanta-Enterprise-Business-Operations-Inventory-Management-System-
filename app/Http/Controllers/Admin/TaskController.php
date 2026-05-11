<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TaskDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaskRequest;
use App\Http\Services\InsertProductTransaction;
use App\Http\Services\UpdateProductQuantity;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Engineer;
use App\Models\Product;
use App\Models\Task;
use App\Models\TaskProduct;
use App\Models\User;
use App\Notifications\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $UpdateProductQuantity;
    protected $insertProductTransaction;

    public function __construct(UpdateProductQuantity $UpdateProductQuantity, InsertProductTransaction $insertProductTransaction)
    {
        $this->insertProductTransaction = $insertProductTransaction;
        $this->UpdateProductQuantity = $UpdateProductQuantity;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::all();

        $query = Task::query();

        if ($request->client_id) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $tasksNew = (clone $query)->where('status', 'new')
            ->orderBy('created_at', 'DESC')
            ->paginate(6, ['*'], 'new_page')
            ->withQueryString();

        $tasksPending = (clone $query)->where('status', 'completed')
            ->orderBy('created_at', 'DESC')
            ->paginate(6, ['*'], 'pending_page')
            ->withQueryString();

        $tasksCancelled = (clone $query)->where('status', 'cancelled')
            ->orderBy('created_at', 'DESC')
            ->paginate(6, ['*'], 'cancelled_page')
            ->withQueryString();


        return view('admin.tasks.index', compact('tasksNew', 'tasksPending', 'tasksCancelled', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $engineers = Engineer::all();
        $clients = Client::all();
        $products = Product::where('type', 'fix')->get();
        return view('admin.tasks.create', compact('engineers', 'clients', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth('admin')->id();
        $data = $this->calculateCommission($data);
        $task = Task::create([
            'client_id' => $data['client_id'],
            'engineer_id' => $data['engineer_id'],
            'description' => $data['description'],
            'notes' => $data['notes'],
            'status' => $data['status'],
            'cost' => $data['cost'],
            'created_by' => auth('admin')->id(),
            'payed' => $data['payed'],
            'receipt_date' => $data['receipt_date'],
            'due_date' => $data['due_date'],
            'commission' => $data['commission'],
            'serial_number' => $data['serial_number'],
            'device_type' => $data['device_type'],
            'commission_pound' => $data['commission_pound'],
            'profit' => $data['profit'],
        ]);
        foreach ($data['products'] as $product) {
            TaskProduct::create([
                'product_id' => $product['item_id'],
                'task_id' => $task->id,
                'quantity' => $product['quantity'],
            ]);
            $this->insertProductTransaction->insertProductTransaction($product['item_id'], $product['quantity'], get_class($task), $task->id, 'out');
            $this->UpdateProductQuantity->decreaseQuantity($product['item_id'], $product['quantity']);
        }
        $print_url = route('admin.task.print', $task->id);
        notyf()->addSuccess('تم اضافه الصيانه بنجاح');
        return redirect()->route('admin.task.index')->with('print_url', $print_url);
    }

    private function calculateCommission($data)
    {
        $totalProductCost = 0;
        foreach ($data['products'] as $product) {
            $productPurchasePrice = Product::find($product['item_id'])->purchase_price;
            $totalProductCost += $productPurchasePrice * $product['quantity'];
        }
        $commission = ($data['cost'] - $totalProductCost) * ($data['commission'] / 100);
        $data['commission_pound'] = $commission;
        $data['profit'] = $data['cost'] - $totalProductCost - $commission;
        return $data;
    }

    public function print($id)
    {

        $task = \App\Models\Task::with(['client', 'engineer'])->findOrFail($id);
        return view('admin.tasks.print_pages.print_task_recet', compact('task'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['client', 'engineer', 'admin', 'products']);
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $engineers = Engineer::all();
        $clients = Client::all();
        return view('admin.tasks.edit', compact('task', 'engineers', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();
        $data['created_by'] = auth('admin')->id();

        $task->update([
            'client_id' => $data['client_id'],
            'engineer_id' => $data['engineer_id'],
            'description' => $data['description'],
            'notes' => $data['notes'],
            'status' => $data['status'],
            'cost' => $data['cost'],
            'payed' => $data['payed'],
            'receipt_date' => $data['receipt_date'],
            'due_date' => $data['due_date'],
            'serial_number' => $data['serial_number'],
            'device_type' => $data['device_type'],
        ]);

        notyf()->addSuccess('تم تحديث الصيانه بنجاح');
        return redirect()->route('admin.task.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {

    }

    public function updateStatus(Task $task, Request $request)
    {

        $newStatus = $request->newStatus;
        $task->update(['status' => $newStatus]);

        if ($newStatus === 'completed') {
            $engineer = auth('engineer')->user();
            foreach (Admin::all() as $admin) {
                $admin->notify(new SendNotification('task', $task->load('engineer')));
            }
        }
        \Flasher\Notyf\Prime\notyf()->addSuccess('تم تغيير الحاله بنجاح');
        return redirect()->route('admin.engineer.tasks');
    }

}
