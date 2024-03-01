<?php
$data = $ci->db->query("SELECT * FROM manage_survey
JOIN users ON manage_survey.id_user = users.id
WHERE slug = '" . $ci->uri->segment(2) . "'")->row();
?>

<div class="text-center mt-5 mb-5">
	<div class="">
	Presented by
	</div>
	<div class="font-weight-bold">
		www.<?php echo e($data->definition_company); ?>.com
	</div>
</div>
<?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/include_backend/partials_survei/footer_survei.blade.php ENDPATH**/ ?>