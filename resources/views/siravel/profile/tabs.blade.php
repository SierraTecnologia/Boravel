<div class="row customer-tabs">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link @if (Request::is('siravel.account.profile')) active @endif" href="{{ route('siravel.account.profile') }}">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (Request::is('siravel.account.card')) active @endif" href="{{ route('siravel.account.card') }}">Credit Card</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (Request::is('store/account/coupon')) active @endif" href="{{ url('store/account/coupon') }}">Coupon</a>
        </li>
    </ul>
</div>