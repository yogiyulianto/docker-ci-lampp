@extends('settings.profile.index')
@section('app_content')
<div class="card-body">
    <ol class="activity-feed">
        @forelse ($rs_id as $item)
            @if ($item['action_type'] == 'C')
                @php $color = 'info' @endphp
                @elseif ($item['action_type'] == 'U')
                @php $color = 'success' @endphp
                @elseif($item['action_type'] == 'D')
                @php $color = 'danger' @endphp
            @endif
        <li class="feed-item feed-item-{{$color}}">
            <div class="date" datetime="9-25">{{$this->tdtm->nicetime($item['mdd'])}}</div>
            <span class="text">{{$item['log_message']}}</span>
        </li>
        @empty
        <li class="feed-item feed-item-secondary">
            <time class="date" datetime="9-25"></time>
            <span class="text">Log Empty</span>
        </li>
        @endforelse
    </ol>
</div>
@if (isset($pagination))
<div class="card-footer">
    @php echo $pagination @endphp
</div>
@endif
@endsection