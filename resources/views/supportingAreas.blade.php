@extends('layouts.customer', ['pageTitle' => 'مناطق تحت پوشش', 'withNavigation' => true, 'backUrl' => '/' ])
@section('content')

<div class="container" style="margin-top:70px;color:#222;">
    <h4>مناطق تحت پوشش سرویس دهی همسود</h4>
    <hr>
    <ul>
    @foreach($areas as $area)
        <li>{{$area->supporting_area}}</li>
    @endforeach
    </ul>

    <img src="/images/supporting_areas.png" height="400" style="width:100%;max-width:400px;" />
</div>

@endsection
