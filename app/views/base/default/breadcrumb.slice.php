
@php
$ci = &get_instance();
@endphp
<!-- Breadcrumbs-->
<ul class="breadcrumbs ">
    <li class="nav-home">
        <a href="{{ base_url($com_user['default_page']) }}" >
            <i class="las la-home"></i>
        </a>
    </li>
    @foreach ($ci->uri->segments as $segment)
        @php
        $url = substr($ci->uri->uri_string, 0, strpos($ci->uri->uri_string, $segment)) . $segment;
        $is_active =  $url == $ci->uri->uri_string;
        @endphp
         <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#" >
                @php $segment = ucwords(str_replace("_"," ", $segment)) @endphp
                {{ $segment }}
            </a>
        </li>
    @endforeach
</ul>
<!-- End Breadcrumbs-->
