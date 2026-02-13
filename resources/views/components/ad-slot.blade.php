@if($ads && $ads->count() > 0)
<div class="ad-slot ad-slot-{{ $position }}">
    @foreach($ads as $ad)
    <div class="ad-item mb-4">
        {!! $ad->render() !!}
    </div>
    @endforeach
</div>
@endif
