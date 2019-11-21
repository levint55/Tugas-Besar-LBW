<?php 
$ci =& get_instance();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


<script type="text/javascript">
$(document).ready(function(){
    <?php if($ci->session->flashdata('success')){ ?>
        toastr.success("<?php echo $ci->session->flashdata('success'); ?>");
    <?php }else if($ci->session->flashdata('error')){  ?>
        toastr.error("<?php echo $ci->session->flashdata('error'); ?>");
    <?php }else if($ci->session->flashdata('warning')){  ?>
        toastr.warning("<?php echo $ci->session->flashdata('warning'); ?>");
    <?php } ?>
})
</script>