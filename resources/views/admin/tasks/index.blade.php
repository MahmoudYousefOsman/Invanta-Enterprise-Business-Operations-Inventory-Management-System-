@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="col-lg-11 mx-auto">

            {{-- 🔍 Search Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.task.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">العميل</label>
                            <select name="client_id" class="form-select">
                                <option value="">اختر العميل</option>
                                @foreach($clients as $client)
                                    <option
                                        value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">من تاريخ</label>
                            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                        </div>

                        <div class="col-md-1 text-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-search"></i> بحث
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- New Tasks --}}
            <h2 class="mb-4">التاسكات الجديده</h2>
            <div class="row row-cards">
                @forelse($tasksNew as $task)
                    @include('admin.tasks.partials.task_card', ['task' => $task , 'color'=>'blue'])
                @empty
                    <p class="text-muted text-center">لا يوجد تاسكات جديده</p>
                @endforelse
            </div>
            <div class="mt-3">
                {{ $tasksNew->links('admin.partials.pagination') }}
            </div>

            {{-- Pending Tasks --}}
            <h2 class="mb-4 mt-5">التاسكات المكتمله</h2>
            <div class="row row-cards">
                @forelse($tasksPending as $task)
                    @include('admin.tasks.partials.task_card', ['task' => $task ,'color'=>'success'])
                @empty
                    <p class="text-muted text-center">لا يوجد تاسكات مكتمله</p>
                @endforelse
            </div>
            <div class="mt-3">
                {{ $tasksPending->links('admin.partials.pagination') }}
            </div>

            {{-- Cancelled Tasks --}}
            <h2 class="mb-4 mt-5">التاسكات الملغيه</h2>
            <div class="row row-cards">
                @forelse($tasksCancelled as $task)
                    @include('admin.tasks.partials.task_card', ['task' => $task,'color'=>'danger'])
                @empty
                    <p class="text-muted text-center">لا يوجد تاسكات ملغيه</p>
                @endforelse
            </div>
            <div class="mt-3">
                {{ $tasksCancelled->links('admin.partials.pagination') }}
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    @if(session('print_url'))
        <script>
            window.open("{{ session('print_url') }}", "_blank");
        </script>
    @endif
@endpush
