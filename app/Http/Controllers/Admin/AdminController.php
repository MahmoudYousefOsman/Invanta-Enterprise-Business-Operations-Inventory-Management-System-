<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Order;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;


class AdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
//        return [
//            new Middleware(PermissionMiddleware::using('admins view'  , 'admin'), only:['index','show']),
//            new Middleware(PermissionMiddleware::using('admins create'  , 'admin'), only:['create','store']),
//            new Middleware(PermissionMiddleware::using('admins edit' , 'admin'), only:['edit','update']),
//            new Middleware(PermissionMiddleware::using('admins delete' , 'admin'), only:['destroy']),
//        ];
    }

    public function index(Request $request): View
    {

        $admins = Admin::paginate(20);
        $permission = Auth::guard("admin")->user();
        $roles = Role::pluck('name')->all();
        return view('admin.admins.index', compact('admins', "permission"));
    }

    public function store(AdminStoreRequest $request): RedirectResponse
    {
        // dd($request->all());
        $data = $request->safe()->only(['name', 'email', 'active', 'profile_pic']);

        $data['active'] = $data['active'] ?? false;

        $data['password'] = Hash::make($request->password);

        if (is_file($request->profile_pic)) {
            $data['profile_pic'] = $request->file('profile_pic')->store('admins', 'public');
        }

        $admin = \App\Models\Admin::create($data);

        $admin->assignRole($request->role);

        notyf()->addSuccess(__('Successfully created.'));

        return redirect()->route('admin.admins.index');
    }

    public function show(String $id)
    {
        $admin = Admin::findOrFail($id);
        $permission = Auth::guard("admin")->user();

        $checkAdmin = ($admin->id !== Auth::guard("admin")->user()->id);

        return view("admin.admins.show", compact("admin", "checkAdmin", "permission"));
    }

    public function edit(\App\Models\Admin $admin)
    {
        $roles = Role::pluck('name')->all();

        $adminRole = $admin->roles->pluck('name')->all();

        return view('admin.admins.edit', compact('admin', 'roles', 'adminRole'));
    }

    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        // dd($request->all());
        $data = $request->safe()->only(['name', 'email', 'active', 'profile_pic']);

        $data['active'] = $data['active'] ?? false;

        if (is_file($request->profile_pic)) {
            if ($admin->profile_pic)
                File::delete(storage_path('app/public/' . $admin->profile_pic));

            $data['profile_pic'] = $request->file("profile_pic")->store('admins', 'public');
        }

        if ($request->has('password') && !empty($request->password))
            $data['password'] = Hash::make($request->password);

        $admin->update($data);

        DB::table('model_has_roles')->where('model_id', $admin->id)->delete();

        $admin->assignRole($request->role);

        notyf()->addSuccess(__('Successfully updated.'));

        if ($request->expectsJson()) {
            return response()->json(['message' => __('Successfully updated.'), 'redirect' => route('admin.admins.index')]);
        }

        return redirect()->route('admin.admins.index');
    }

    public function destroy(Request $request, \App\Models\Admin $admin): RedirectResponse
    {
        if (auth()->guard('admin')->id() == $admin->id) {
            notyf()->addError(__('You can not delete your own account.'));
        } else {
            if ($admin->profile_pic)
                File::delete(storage_path('app/public/' . $admin->profile_pic));

            $admin->delete();

            notyf()->addSuccess(__('Successfully deleted.'));
        }

        return redirect()->route('admin.admins.index');
    }

    public function statistics()
    {
        // 1. Base date calculations
        $days7 = collect();
        for ($i = 6; $i >= 0; $i--) {
            $days7->put(now()->subDays($i)->format('Y-m-d'), 0);
        }

        $days15 = collect();
        for ($i = 14; $i >= 0; $i--) {
            $days15->put(now()->subDays($i)->format('Y-m-d'), 0);
        }

        // Welcome Box Metrics
        $adminName = auth()->guard('admin')->user()->name ?? 'المدير';
        $newMessagesCount = \App\Models\Task::where('status', 'new')->count();
        $newNotificationsCount = \App\Models\Client::where('new_client', true)->count();
        $todaySalesCount = \App\Models\Order::whereDate('created_at', today())->count();
        $todaySalesSum = \App\Models\Order::whereDate('created_at', today())->sum('total_price');
        $yesterdaySalesSum = \App\Models\Order::whereDate('created_at', today()->subDay())->sum('total_price');
        $todaySalesGrowth = 0;
        if ($yesterdaySalesSum > 0) {
            $todaySalesGrowth = (($todaySalesSum - $yesterdaySalesSum) / $yesterdaySalesSum) * 100;
        }

        // Growth rate: this month's revenue vs last month's
        $thisMonthSales = \App\Models\Order::where('created_at', '>=', now()->startOfMonth())->sum('total_price');
        $lastMonthSales = \App\Models\Order::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->sum('total_price');
        $growthRatePercent = 0;
        if ($lastMonthSales > 0) {
            $growthRatePercent = (($thisMonthSales - $lastMonthSales) / $lastMonthSales) * 100;
        }

        // 2. TOTAL USERS (Total Clients)
        $totalClientsCount = \App\Models\Client::count();
        $clientsThisMonth = \App\Models\Client::where('created_at', '>=', now()->startOfMonth())->count();
        $clientsLastMonth = \App\Models\Client::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();
        $clientsGrowthPercent = 0;
        if ($clientsLastMonth > 0) {
            $clientsGrowthPercent = (($clientsThisMonth - $clientsLastMonth) / $clientsLastMonth) * 100;
        }
        $clientsLast15DaysRaw = \App\Models\Client::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(15))
            ->groupBy('date')
            ->pluck('count', 'date');
        $totalUsersSparkline = $days15->merge($clientsLast15DaysRaw)->values()->all();

        // 3. ACTIVE USERS (Active Clients in the last 30 days)
        $activeClientsCount = \App\Models\Client::whereHas('orders', function($q) {
            $q->where('created_at', '>=', now()->subDays(30));
        })->orWhereHas('tasks', function($q) {
            $q->where('created_at', '>=', now()->subDays(30));
        })->count();
        $activeClientsPercent = $totalClientsCount > 0 ? round(($activeClientsCount / $totalClientsCount) * 100) : 0;
        $activeClientsThisMonth = \App\Models\Client::where(function($q) {
            $q->whereHas('orders', function($o){ $o->where('created_at', '>=', now()->startOfMonth()); })
              ->orWhereHas('tasks', function($t){ $t->where('created_at', '>=', now()->startOfMonth()); });
        })->count();
        $activeClientsLastMonth = \App\Models\Client::where(function($q) {
            $q->whereHas('orders', function($o){ $o->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]); })
              ->orWhereHas('tasks', function($t){ $t->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]); });
        })->count();
        $activeClientsGrowthPercent = 0;
        if ($activeClientsLastMonth > 0) {
            $activeClientsGrowthPercent = (($activeClientsThisMonth - $activeClientsLastMonth) / $activeClientsLastMonth) * 100;
        }

        // 4. Second Row Sparklines
        // Card 1: Sales
        $salesCount7Days = \App\Models\Order::where('created_at', '>=', now()->subDays(7))->count();
        $salesCountPrior7Days = \App\Models\Order::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $salesGrowth7Days = 0;
        if ($salesCountPrior7Days > 0) {
            $salesGrowth7Days = (($salesCount7Days - $salesCountPrior7Days) / $salesCountPrior7Days) * 100;
        }
        $clientsWithOrders = \App\Models\Client::whereHas('orders')->count();
        $conversionRate = $totalClientsCount > 0 ? round(($clientsWithOrders / $totalClientsCount) * 100) : 0;
        $sales7DaysRaw = \App\Models\Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->pluck('count', 'date');
        $salesSparkline = $days7->merge($sales7DaysRaw)->values()->all();

        // Card 2: Revenue
        $revenue7Days = \App\Models\Order::where('created_at', '>=', now()->subDays(7))->sum('total_price');
        $revenuePrior7Days = \App\Models\Order::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->sum('total_price');
        $revenueGrowth7Days = 0;
        if ($revenuePrior7Days > 0) {
            $revenueGrowth7Days = (($revenue7Days - $revenuePrior7Days) / $revenuePrior7Days) * 100;
        }
        $revenue7DaysRaw = \App\Models\Order::selectRaw('DATE(created_at) as date, SUM(total_price) as sum')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->pluck('sum', 'date');
        $revenueSparkline = $days7->merge($revenue7DaysRaw)->values()->all();

        // Card 3: New Clients
        $newClients7Days = \App\Models\Client::where('created_at', '>=', now()->subDays(7))->count();
        $newClientsPrior7Days = \App\Models\Client::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $newClientsGrowth7Days = 0;
        if ($newClientsPrior7Days > 0) {
            $newClientsGrowth7Days = (($newClients7Days - $newClientsPrior7Days) / $newClientsPrior7Days) * 100;
        }
        $newClients7DaysRaw = \App\Models\Client::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->pluck('count', 'date');
        $newClientsSparkline = $days7->merge($newClients7DaysRaw)->values()->all();

        // Card 4: Active Maintenance
        $activeTasksCount = \App\Models\Task::where('status', 'new')->count();
        $tasks7Days = \App\Models\Task::where('created_at', '>=', now()->subDays(7))->count();
        $tasksPrior7Days = \App\Models\Task::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $tasksGrowth7Days = 0;
        if ($tasksPrior7Days > 0) {
            $tasksGrowth7Days = (($tasks7Days - $tasksPrior7Days) / $tasksPrior7Days) * 100;
        }
        $tasks7DaysRaw = \App\Models\Task::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->pluck('count', 'date');
        $tasksSparkline = $days7->merge($tasks7DaysRaw)->values()->all();

        // 5. Third Row Small Cards
        $salesCount = \App\Models\Order::count();
        $unpaidTasksCount = \App\Models\Task::whereRaw('payed < cost')->count();
        $tasksCount = \App\Models\Task::count();
        $completedTasksCount = \App\Models\Task::where('status', 'completed')->count();
        $purchasesCount = \App\Models\Purchase::count();
        $supplierPaymentsCount = \App\Models\SupplierPayment::count();
        $productsCount = \App\Models\Product::count();
        $lowStockCount = \App\Models\Product::where('quantity', '<=', 5)->count();

        // 6. Fourth Row: Traffic Summary & Locations
        $orders15DaysRaw = \App\Models\Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(15))
            ->groupBy('date')
            ->pluck('count', 'date');
        $tasks15DaysRaw = \App\Models\Task::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(15))
            ->groupBy('date')
            ->pluck('count', 'date');
        
        $trafficOrders = $days15->merge($orders15DaysRaw);
        $trafficTasks = $days15->merge($tasks15DaysRaw);
        $trafficLabels = $trafficOrders->keys()->map(function($date) {
            return date('d M', strtotime($date));
        })->all();


        // 7. Storage Breakdown (Database rows conversion to MB representation)
        $regularRows = \App\Models\Order::count() + \App\Models\Purchase::count();
        $systemRows = \App\Models\Admin::count() + \App\Models\Task::count();
        $sharedRows = \App\Models\Product::count() + \App\Models\Client::count() + \App\Models\Engineer::count() + \App\Models\Supplier::count();
        
        $totalMB = 8192; // 8 GB
        $regularMB = min(round(($regularRows / 5000) * 8192, 1) + 120, 4000);
        $systemMB = min(round(($systemRows / 5000) * 8192, 1) + 80, 2000);
        $sharedMB = min(round(($sharedRows / 5000) * 8192, 1) + 150, 2000);
        $usedMB = $regularMB + $systemMB + $sharedMB;
        $freeMB = max($totalMB - $usedMB, 512);

        // 8. Earning Patterns (Orders + Completed Tasks cost per day in the last 15 days)
        $ordersEarnings15Days = \App\Models\Order::selectRaw('DATE(created_at) as date, SUM(total_price) as sum')
            ->where('created_at', '>=', now()->subDays(15))
            ->groupBy('date')
            ->pluck('sum', 'date');
        $tasksEarnings15Days = \App\Models\Task::selectRaw('DATE(created_at) as date, SUM(cost) as sum')
            ->where('created_at', '>=', now()->subDays(15))
            ->groupBy('date')
            ->pluck('sum', 'date');
        
        $earnings15Days = collect();
        foreach ($days15 as $date => $val) {
            $earnings15Days->put($date, ($ordersEarnings15Days->get($date, 0) + $tasksEarnings15Days->get($date, 0)));
        }
        $earningsSparkline = $earnings15Days->values()->all();
        $earningsLabels = $earnings15Days->keys()->map(function($d) {
            return date('d M', strtotime($d));
        })->all();
        $todayEarningSum = $earnings15Days->last() ?? 0;
        $yesterdayEarningSum = $earnings15Days->slice(-2, 1)->first() ?? 0;
        $earningDiffPercent = 0;
        if ($yesterdayEarningSum > 0) {
            $earningDiffPercent = (($todayEarningSum - $yesterdayEarningSum) / $yesterdayEarningSum) * 100;
        }

        // Recent Transactions Table (latest orders and tasks)
        $recentOrders = \App\Models\Order::with('client')->latest()->take(5)->get()->map(function($item) {
            return [
                'user' => $item->client->name ?? 'غير معروف',
                'operation' => 'طلب شراء #' . $item->code,
                'amount' => number_format($item->total_price, 2) . ' ج.م',
                'date' => $item->created_at->format('d M Y')
            ];
        });
        $recentTasks = \App\Models\Task::with('client')->latest()->take(5)->get()->map(function($item) {
            return [
                'user' => $item->client->name ?? 'غير معروف',
                'operation' => 'طلب صيانة ' . $item->device_type,
                'amount' => number_format($item->cost, 2) . ' ج.م',
                'date' => $item->created_at->format('d M Y')
            ];
        });
        $recentTransactions = $recentOrders->concat($recentTasks)->sortByDesc(function($item) {
            return strtotime($item['date']);
        })->take(5)->values()->all();

        // 9. Activity Feed
        $latestClients = \App\Models\Client::latest()->take(3)->get()->map(function($item) {
            return [
                'icon' => 'user-plus',
                'bg' => 'bg-blue-lt',
                'text' => 'تم تسجيل عميل جديد باسم: ' . $item->name,
                'time' => $item->created_at
            ];
        });
        $latestTasks = \App\Models\Task::with('client')->latest()->take(3)->get()->map(function($item) {
            return [
                'icon' => 'tool',
                'bg' => 'bg-yellow-lt',
                'text' => 'طلب صيانة جديد لجهاز: ' . $item->device_type . ' للعميل: ' . ($item->client->name ?? 'غير معروف'),
                'time' => $item->created_at
            ];
        });
        $latestOrders = \App\Models\Order::with('client')->latest()->take(3)->get()->map(function($item) {
            return [
                'icon' => 'shopping-cart',
                'bg' => 'bg-green-lt',
                'text' => 'طلب شراء جديد للعميل: ' . ($item->client->name ?? 'غير معروف') . ' بقيمة ' . number_format($item->total_price, 2) . ' ج.م',
                'time' => $item->created_at
            ];
        });
        $latestReturns = \App\Models\InvoiceReturn::latest()->take(3)->get()->map(function($item) {
            return [
                'icon' => 'refresh',
                'bg' => 'bg-red-lt',
                'text' => 'تم إرجاع فاتورة بقيمة ' . number_format($item->total_price ?? 0, 2) . ' ج.م',
                'time' => $item->created_at
            ];
        });
        $activityFeed = collect()
            ->concat($latestClients)
            ->concat($latestTasks)
            ->concat($latestOrders)
            ->concat($latestReturns)
            ->sortByDesc('time')
            ->take(6)
            ->values()
            ->map(function($item) {
                $item['time_diff'] = $item['time']->diffForHumans();
                return $item;
            })
            ->all();

        return view('statistics', compact(
            'adminName',
            'newMessagesCount',
            'newNotificationsCount',
            'todaySalesCount',
            'todaySalesSum',
            'todaySalesGrowth',
            'growthRatePercent',
            
            'totalClientsCount',
            'clientsGrowthPercent',
            'totalUsersSparkline',
            
            'activeClientsCount',
            'activeClientsPercent',
            'activeClientsGrowthPercent',
            
            'salesCount7Days',
            'salesGrowth7Days',
            'conversionRate',
            'salesSparkline',
            
            'revenue7Days',
            'revenueGrowth7Days',
            'revenueSparkline',
            
            'newClients7Days',
            'newClientsGrowth7Days',
            'newClientsSparkline',
            
            'activeTasksCount',
            'tasksGrowth7Days',
            'tasksSparkline',
            
            'salesCount',
            'unpaidTasksCount',
            'tasksCount',
            'completedTasksCount',
            'purchasesCount',
            'supplierPaymentsCount',
            'productsCount',
            'lowStockCount',
            
            'trafficOrders',
            'trafficTasks',
            'trafficLabels',
            
            'regularMB',
            'systemMB',
            'sharedMB',
            'freeMB',
            'usedMB',
            'totalMB',
            
            'earningsSparkline',
            'earningsLabels',
            'todayEarningSum',
            'earningDiffPercent',
            'recentTransactions',
            'activityFeed'
        ));
    }

}
