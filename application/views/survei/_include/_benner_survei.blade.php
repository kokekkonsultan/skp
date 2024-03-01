@php
$title_header = unserialize($manage_survey->title_header_survey);
$title_1 = $title_header[0];
$title_2 = $title_header[1];


$color = unserialize($manage_survey->warna_benner);
$color1 = $color[0];
$color2 = $color[1];
$color3 = $color[2];
@endphp

@if($manage_survey->is_benner == 2)
<div class="card-header" style="background-color: #E4E6EF;">
    <div class="text-center font-text-header font-weight-bolder mt-5 mb-5">
        <span class="font-weight-bolder">{{strtoupper($title_1)}}</span>
        <br>
        <span class="font-weight-bolder mt-3">{{strtoupper($title_2)}}</span>
    </div>
</div>

@elseif($manage_survey->is_benner == 3)
<div class="card-header" style="background-color: <?= $color1 ?>;">
    <div class="text-center font-text-header font-weight-bolder mt-5 mb-5">
        <span class="font-weight-bolder">{{strtoupper($title_1)}}</span>
        <br>
        <span class="font-weight-bolder mt-3">{{strtoupper($title_2)}}</span>
    </div>
</div>

@elseif($manage_survey->is_benner == 4)
<div class="card-header" style="background-image: linear-gradient(to bottom right, <?= $color2 . ', ' . $color3 ?>);">
    <div class="text-center font-text-header font-weight-bolder mt-5 mb-5">
        <span class="font-weight-bolder">{{strtoupper($title_1)}}</span>
        <br>
        <span class="font-weight-bolder mt-3">{{strtoupper($title_2)}}</span>
    </div>
</div>

@elseif($manage_survey->is_benner == 5)
<div class="card-header" style="background-color: <?= $color1 ?>;">
    <table class="table table-borderless mt-5" width="100%">
        <tr>
            <td width="15%" style="vertical-align:middle;">
                <img src="{{base_url() . 'assets/klien/foto_profile/200px.jpg'}}" height="100" width="100" alt="">
            </td>
            <td class="font-text-header" style="vertical-align:middle;">
                <span class="font-weight-bolder">{{strtoupper($title_1)}}</span>
                <br>
                <span class="font-weight-bolder mt-3">{{strtoupper($title_2)}}</span>
            </td>
        </tr>
    </table>
</div>

@else

@if($manage_survey->img_benner == '')
<img class="card-img-top" src="{{ base_url() }}assets/img/site/page/banner-survey.jpg" alt="new image" />
@else
<img class="card-img-top shadow" src="{{ base_url() }}assets/klien/benner_survei/{{$manage_survey->img_benner}}" alt="new image">
@endif

@endif
