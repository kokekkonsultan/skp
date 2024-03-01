@php
$data = $ci->db->query("SELECT * FROM manage_survey
JOIN users ON manage_survey.id_user = users.id
WHERE slug = '" . $ci->uri->segment(2) . "'")->row();
@endphp

<div class="text-center mt-5 mb-5">
	<div class="">
	Presented by
	</div>
	<div class="font-weight-bold">
		www.{{$data->definition_company}}.com
	</div>
</div>
