<div class="row d-flex justify-content-between text-center">
    <a class="col-xl-4 buttons {{ (url()->current() == url('/notifications')) ? 'active' : '' }}" href="{{ route('notifications.index') }}">
        <div>
            All notifications
        </div>
    </a>
    <a class="col-xl-4 buttons {{ (url()->current() == url('/unread-notifications')) ? 'active' : '' }}" href="{{ route('notifications.unread') }}">
        <div>
            Unread notifications
        </div>
    </a>
    <a class="col-xl-4 buttons {{ (url()->current() == url('/read-notifications')) ? 'active' : '' }}"" href="{{ route('notifications.read') }}">
        <div>
            Read notifications
        </div>
    </a>
</div>