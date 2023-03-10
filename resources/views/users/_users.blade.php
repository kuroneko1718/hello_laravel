<div class="list-group-item">
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="mr-3" width="32">
    <a href="{{ route('users.show', $user) }}">
        {{ $user->name }}
    </a>
    @can('destroy', $user)
    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="float-right">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-danger btn-sm delete-btn">删除</button>
    </form>
    @endcan
</div>