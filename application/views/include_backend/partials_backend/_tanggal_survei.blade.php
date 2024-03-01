@php
$ci = get_instance();
$slug = $ci->uri->segment(2);

$identitas_survey = $ci->db->query("
SELECT *, DATE_FORMAT(survey_end, '%d %M %Y') AS survey_selesai, IF(CURDATE() > survey_end,1,NULL) AS survey_berakhir,
IF(CURDATE() < survey_start ,1,NULL) AS survey_belum_mulai FROM manage_survey JOIN users ON manage_survey.id_user=users.id WHERE slug='$slug' ")->row();
@endphp

@if($identitas_survey->is_display_tanggal_survei == 'true')
MOHON DIISI SEBELUM TANGGAL <strong>{{ $identitas_survey->survey_selesai }}</strong>
@endif