<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">


    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ TEMPLATE_BACKEND_PATH }}css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/png" href="{{ base_url() }}assets/img/site/content/favicon.png"/>
    <link href="{{ TEMPLATE_BACKEND_PATH }}plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ VENDOR_PATH }}aos/aos.css">


    <style>
    html,
    body {
        height: 100%;
        font-family: 'Inter', sans-serif;
    }

    #navigasi {
        width: 100%;
        height: 100%;
        display: flex;
    }

    #group-nav {
        display: flex;
        width: 30%;
        height: 100%;
        /* background-color: #EAEBF4; */
        background-image: linear-gradient(to right, #EFF8FA, #EADFEF);
        color: #f3f3f3;
        overflow: scroll;
    }

    #primary-menu {
        width: 55px;
    }

    #sub-primary-menu {
        box-shadow: 5px 10px 18px #888888;
        background-color: #1E1E2D;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
        color: #494B74;
        height: auto;
        padding: 5px;
        transition-property: width;
        transition-duration: 0.3s;
        width: 55px;
        z-index: 10000;
        position: relative;
    }

    #sub-primary-menu:hover {
        width: 200px;
        z-index: 10000;
    }

    #sub-primary-menu a {
        color: #a2a3b7;
        text-decoration: none;
    }

    #sub-primary-menu a:hover {
        color: #ffffff;
    }
    

    .in-primary-group {
        display: flex;
        flex-direction: row;
    }

    .in-primary-menu {
        height: 40px;
        width: 60px;
        /* background-color: #EAEBF4; */
        margin: 5px;
        cursor: pointer;
        font-size: 20px;
        text-align: center;
        line-height: 40px;
    }

    .in-primary-label {
        height: 40px;
        width: 500px;
        /* background-color: #EAEBF4; */
        margin: 5px;
        cursor: pointer;
        visibility: hidden;
        font-size: 14px;
        /* font-weight: bold; */
        padding-top: 9px;
        /* color: #f3f3f3; */
    }

    .in-primary-label a {
        color: #f3f3f3;
        text-decoration: none;
        font-weight: 500;
    }

    .in-primary-label>a:hover {
        color: #494B74;
    }

    #secondary-menu {
        width: 100%;
        padding: 15px;
        color: #1E1E2D;
        z-index: 10;
        position: relative;
    }

    .secondary-label {
        width: 100%;
        border: 1px solid #1E1E2D;
        margin-bottom: 15px;
        font-size: 18px;
        color: #1E1E2D;
        padding: 10px;
        border-radius: 30px;
        text-align: center;
        font-weight: bold;
    }

    #form-preview {
        background-color: #f3f3f3;
        height: auto;
        overflow: scroll;
        width: 70%;
        z-index: 10;
        position: relative;
    }

    </style>





    @php
    $slug = $ci->uri->segment(2);
    $manage_survey = $ci->db->get_where("manage_survey", array('slug' => "$slug"))->row();
    $is_question = $manage_survey->is_question;

    $title_header = unserialize($manage_survey->title_header_survey);
    $title_1 = $title_header[0];
    $title_2 = $title_header[1];


    $color = unserialize($manage_survey->warna_latar_belakang);
    $color1 = $color[0];
    $color2 = $color[1];
    $color3 = $color[2];

    if($manage_survey->is_latar_belakang == 2){
        $background = 'background-color: ' . $color1;
    } elseif($manage_survey->is_latar_belakang == 3) {
        $background = 'background-image: linear-gradient(to bottom right, ' . $color2 . ', ' . $color3 . ')';
    } else {
        $background = 'background-image: url(' . base_url() . 'assets/img/bg/main-bg.jpg)';
        
    }


    $font_text_header = unserialize($manage_survey->font_text_header);
    $font_type_header = $ci->db->get_where('fonts_google', ['id' => $font_text_header[0]])->row()->css_rules;
    $font_size_header = $font_text_header[1];
    $font_color_header = $font_text_header[2];


    $font_text_body = unserialize($manage_survey->font_text_body);
    $font_type_body = $ci->db->get_where('fonts_google', ['id' => $font_text_body[0]])->row()->css_rules;
    $font_size_body = $font_text_body[1];
    $font_color_body = $font_text_body[2];


    $font_btn_next = unserialize($manage_survey->font_btn_next);
    $font_type_next = $ci->db->get_where('fonts_google', ['id' => $font_btn_next[0]])->row()->css_rules;
    $font_size_next = $font_btn_next[1];
    $font_color_next = $font_btn_next[2];
    $btn_color_next = $font_btn_next[3];


    $font_btn_back = unserialize($manage_survey->font_btn_back);
    $font_type_back = $ci->db->get_where('fonts_google', ['id' => $font_btn_back[0]])->row()->css_rules;
    $font_size_back = $font_btn_back[1];
    $font_color_back = $font_btn_back[2];
    $btn_color_back = $font_btn_back[3];
    @endphp

    <style>
        .btn-next {
            font-family: <?= $font_type_next ?>;
            font-size: <?=$font_size_next ?>px;
            color: <?= $font_color_next ?>;
            background-color: <?= $btn_color_next ?>;
            font-weight: bolder;
        }

        .btn-back {
            font-family: <?= $font_type_back ?>;
            font-size: <?= $font_size_back ?>px;
            color: <?= $font_color_back ?>;
            background-color: <?= $btn_color_back ?>;
            font-weight: bolder;
        }

        .font-text-header {
            font-family: <?= $font_type_header ?>;
            font-size: <?= $font_size_header ?>px;
            color: <?= $font_color_header ?>;
        }

        .font-text-body {
            font-family: <?= $font_type_body ?>;
            font-size: <?= $font_size_body ?>px;
            color: <?= $font_color_body ?>;
        }
    </style>


<style>
     #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey;
        /*Warna teks saat belum active*/
    }

    #progressbar .active {
        color: #2a3855
    }

    #progressbar li {
        list-style-type: none;
        font-size: 12px;
        float: left;
        position: relative
    }

    #progressbar #account:before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f007";
    }

    #progressbar #personal:before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f15c";
    }

    #progressbar #payment:before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f27a";
    }

    #progressbar #confirm:before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f06a";
    }

    #progressbar #completed:before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f00c";
    }

    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 25%;
        margin: 0 auto 10px auto;
        padding: 2px
    }

    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1
    }

    #progressbar li.active:before,
    #progressbar li.active:after {
        background: linear-gradient(#fdd83e, #fdd83e);
        /* color: #2a3855; */
    }

    #progressbar li {
        width: <?= $manage_survey->is_saran ? '25%' : '33.3%'; ?>;
    }
</style>

    @yield('style')
</head>

<body>

    <div class="" id="navigasi">

        <div class="" id="group-nav">

            @include('setting_form_survei/_include/_nav_menu')

            <div class="" id="secondary-menu">
                <div class="" style="">

                    @yield('content')

                </div>
            </div>
        </div>
        <div class="" id="form-preview" style="background-image: url({{base_url()}}assets/img/bg/main-bg.jpg)">

            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-secondary btn-sm">Live Preview <i
                                class="fas fa-external-link-alt"></i></button>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                @yield('form_preview')
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ TEMPLATE_BACKEND_PATH }}js/scripts.bundle.js"></script>
    <script src="{{ base_url() }}assets/themes/metronic/assets/js/scripts.bundle.js"></script>
    <script src="{{ TEMPLATE_BACKEND_PATH }}plugins/global/plugins.bundle.js"></script>
    <script src="{{ VENDOR_PATH }}aos/aos.js"></script>

    <script>
    AOS.init();
    </script>


    
    <script>
    function show(id) {
        //   document.getElementById(id).style.visibility = "visible";
        document.getElementsByClassName(id)[0].style.visibility = "visible";
        document.getElementsByClassName(id)[1].style.visibility = "visible";
        document.getElementsByClassName(id)[2].style.visibility = "visible";
        document.getElementsByClassName(id)[3].style.visibility = "visible";
        document.getElementsByClassName(id)[4].style.visibility = "visible";
        document.getElementsByClassName(id)[5].style.visibility = "visible";
        document.getElementsByClassName(id)[6].style.visibility = "visible";
        document.getElementsByClassName(id)[7].style.visibility = "visible";
        document.getElementsByClassName(id)[8].style.visibility = "visible";
        document.getElementsByClassName(id)[9].style.visibility = "visible";
    }

    function hide(id) {
        document.getElementsByClassName(id)[0].style.visibility = "hidden";
        document.getElementsByClassName(id)[1].style.visibility = "hidden";
        document.getElementsByClassName(id)[2].style.visibility = "hidden";
        document.getElementsByClassName(id)[3].style.visibility = "hidden";
        document.getElementsByClassName(id)[4].style.visibility = "hidden";
        document.getElementsByClassName(id)[5].style.visibility = "hidden";
        document.getElementsByClassName(id)[6].style.visibility = "hidden";
        document.getElementsByClassName(id)[7].style.visibility = "hidden";
        document.getElementsByClassName(id)[8].style.visibility = "hidden";
        document.getElementsByClassName(id)[9].style.visibility = "hidden";
        //   document.getElementById(id).style.visibility = "hidden";
    }
    </script>
    @yield('javascript')
    
</body>

</html>