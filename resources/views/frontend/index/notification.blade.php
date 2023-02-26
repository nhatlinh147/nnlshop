<div class="btn-group mx-2 dropdown-notifications">

    <a href="#notifications-panel" class="btn px-0 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-bell text-primary" data-count="0" id="result"></i>
    </a>
    <div class="dropdown-container dropdown-menu dropdown-menu-right">
        <div class="dropdown-toolbar">
            <div class="dropdown-toolbar-actions">
                <a href="#">Mark all as read</a>
            </div>
            <h3 class="dropdown-toolbar-title">Notifications (<span class="notif-count">0</span>)
            </h3>
        </div>
        <ul class="menu">
            @foreach (DB::table('notifications')->where('type', 'App\Notifications\PushNotification')->orderBy('created_at', 'DESC')->get() as $item)
                <li class="notification active">
                    <div class="media">
                        <div class="media-left">
                            <div class="media-object">
                                <img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle"
                                    alt="50x50" style="width: 50px; height: 50px;">
                            </div>
                        </div>
                        <div class="media-body">
                            <strong class="notification-title">{{ json_decode($item->data)->title }}</strong>
                            <p class="notification-desc">{{ json_decode($item->data)->content }}</p>
                            <div class="notification-meta">
                                <small class="timestamp">Thêm vào ngày
                                    {{ date('d-m-Y h:m:s ', strtotime($item->created_at)) }}</small>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach

        </ul>
        <div class="dropdown-footer text-center">
            <a href="#">View All</a>
        </div>
    </div>


</div>
