<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ClientDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\Engineer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function index(ClientDataTable $dataTable)
    {
        return $dataTable->render('admin.client.index');
    }

    public function create()
    {
        return view('admin.client.create_1');
    }

    public function chooseForm(Request $request)
    {

        $clients = Client::all();
        $products = Product::all();
        $engineers = Engineer::all();
        $products = Product::all();
        if ($request->has('new_client')) {
            $new_client = $request->new_client;
            $type = $request->type;
            return view('admin.client.create_2', compact('new_client', 'type'));
        } else {
            if ($request->type == 'repair') {
                return view('admin.tasks.create', compact('clients', 'engineers','products'));
            } else {
                return view('admin.orders.create', compact('clients', 'products'));
            }
        }

    }

    public function store(StoreClientRequest $request)
    {

        $validated = $request->validated();
        $validated['new_client'] = $request->has('new_client') ? 1 : 0;
        $client = Client::create($validated);
        Session::put('client_id', $client->id);
        \Flasher\Notyf\Prime\notyf()->addSuccess('تم إضافة العميل بنجاح');
        if ($request->type == 'repair') {
            return redirect()->route('admin.task.create');
        } else {
            return redirect()->route('admin.orders.create');
        }
    }

    public function edit(Client $client)
    {
        return view('admin.client.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $validated = $request->validated();
        $validated['new_client'] = $request->has('new_client') ? 1 : 0;
        $client->update($validated);

        \Flasher\Notyf\Prime\notyf()->addSuccess('تم تعديل العميل بنجاح');
        return redirect()->route('admin.clients.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        \Flasher\Notyf\Prime\notyf()->addSuccess('تم حذف العميل بنجاح');
        return redirect()->route('admin.clients.index');
    }


    public function movements(Request $request)
    {
        $clients = Client::all();

        $ordersQuery = Order::with('client');
        $tasksQuery = Task::with('client');

        if ($request->filled('client_id')) {
            $ordersQuery->where('client_id', $request->client_id);
            $tasksQuery->where('client_id', $request->client_id);
        }

        if ($request->type === 'order') {
            $tasksQuery->whereRaw('1 = 0');
        } elseif ($request->type === 'repair') {
            $ordersQuery->whereRaw('1 = 0');
        }

        $orders = $ordersQuery->latest()->paginate(2, ['*'], 'orders_page');
        $tasks = $tasksQuery->latest()->paginate(2, ['*'], 'tasks_page');

        return view('admin.client.movements', compact('clients', 'orders', 'tasks'));
    }

}
