<div>
    @foreach(\App\Enums\TaskStatus::labels() as $status => $label)
        <table class="table table-striped mb-8 w-full bg-white shadow-md rounded">
            @include('admin.tasks.table', [$status, $label])
        </table>
    @endforeach
</div>
