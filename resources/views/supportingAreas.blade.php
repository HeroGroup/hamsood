@extends('layouts.customer', ['pageTitle' => 'مناطق تحت پوشش', 'withNavigation' => true, 'backUrl' => '/' ])
@section('content')

<div class="container" style="margin:70px 0;color:#222;">
    <h4>مناطق تحت پوشش سرویس دهی همسود</h4>
    <hr>
    <ul>
    @foreach($areas as $area)
        <li>{{$area->supporting_area}}</li>
    @endforeach
    </ul>

    <a href="/images/supporting_areas.png" target="_blank">
        <img src="/images/supporting_areas.png" style="width:100%;" />
    </a>
</div>

@endsection
