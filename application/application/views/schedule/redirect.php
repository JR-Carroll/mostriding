<?php if(isset($redirectUrl) && $redirectUrl != ''){?>
<script>
window.location.href = '<?php echo $redirectUrl?>';
</script>
<?php }?>