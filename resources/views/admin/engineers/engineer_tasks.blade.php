@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl col-lg-10 mx-auto">

            {{-- New Tasks --}}
            <h2 class="mb-4">التاسكات الجديده</h2>
            <div class="row row-cards">
                @forelse($tasksNew as $task)
                    @include('admin.engineers.partials.task_card', ['task' => $task , 'color'=>'blue'])
                @empty
                    <p class="text-muted text-center">لا يوجد تاسكات جديده</p>
                @endforelse
            </div>

            {{-- Pending Tasks --}}
            <h2 class="mb-4 mt-5">التاسكات المكتمله</h2>
            <div class="row row-cards">
                @forelse($tasksPending as $task)
                    @include('admin.engineers.partials.task_card', ['task' => $task ,'color'=>'success'])
                @empty
                    <p class="text-muted text-center">لا يوجد تاسكات مكتمله</p>
                @endforelse
            </div>

            {{-- Cancelled Tasks --}}
            <h2 class="mb-4 mt-5">التاسكات الملغيه</h2>
            <div class="row row-cards">
                @forelse($tasksCancelled as $task)
                    @include('admin.engineers.partials.task_card', ['task' => $task,'color'=>'danger'])
                @empty
                    <p class="text-muted text-center">لا يوجد تاسكات ملغيه</p>
                @endforelse
            </div>

        </div>
    </div>
@endsection


@push('styles')
    <style>
        .cardi {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .cardi:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            transform: translateY(-5px);
        }

        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .badge {
            font-weight: 500;
            padding: 4px 8px;
        }

        .bg-blue-lt {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .bg-green-lt {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .avatar-list-stacked .avatar {
            box-shadow: 0 0 0 2px white;
            margin-left: -0.5rem;
        }

        .switch-icon.active .switch-icon-a {
            opacity: 0;
        }

        .switch-icon.active .switch-icon-b {
            opacity: 1;
        }
    </style>
@endpush

