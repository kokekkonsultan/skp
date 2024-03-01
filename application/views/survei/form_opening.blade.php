@extends('include_backend/_template')

@php
$ci = get_instance();
@endphp

@section('style')
@endsection

@section('content')


<div class="container mt-5 mb-5">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li id="account"><strong>Data Responden</strong></li>
            <li id="personal"><strong>Pertanyaan Survei</strong></li>
            @if($status_saran == 1)
            <li id="payment"><strong>Saran</strong></li>
            @endif
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow" data-aos="fade-up">
                
                @include('survei/_include/_benner_survei')

                <div class="card-body">
                    <div class="font-text-body">
                        @php
                        $slug = $ci->uri->segment(2);

                        $data_user = $ci->db->query("SELECT *
                        FROM manage_survey
                        JOIN users ON manage_survey.id_user = users.id
                        WHERE slug = '$slug'")->row();
                        @endphp

                        {!! $data_user->deskripsi_opening_survey !!}
                    </div>
                    <br><br>
                  
                    @php
                    if($ci->uri->segment(3) != NULL){
                        if($ci->uri->segment(4) == 'do'){
                            $linkSurvei = base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden/' . $ci->uri->segment(3) . '/do';
                        } else {
                            $linkSurvei = base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden/' . $ci->uri->segment(3);
                        }
                    } else {
                        $linkSurvei = base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden';
                    }
                    @endphp

                    <a class="btn btn-next btn-block shadow" href="{{$linkSurvei}}">IKUT SURVEI</a>
                </div>
            </div>
			
        </div>
    </div>
</div>


@endsection

@section('javascript')

@endsection
