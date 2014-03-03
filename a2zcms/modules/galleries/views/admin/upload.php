<style>
	/* Fine Uploader
	 -------------------------------------------------- */
	.qq-upload-list {
		text-align: left;
	}
	/* For the bootstrapped demos */
	li.alert-success {
		background-color: #DFF0D8;
	}
	li.alert-error {
		background-color: #F2DEDE;
	}
	.alert-error .qq-upload-failed-text {
		display: inline;
	}
</style>
<p>
	Gallery: <b><?=$content['title']?></b>
</p>

<div id="jquery-wrapped-fine-uploader"></div>

<!-- Form Actions -->
<div class="form-group">
	<div class="col-md-12">
		<button type="reset" class="btn btn-warning close_popup">
			<span class="icon-remove"></span>  Cancel
		</button>
	</div>
</div>
<script>
		$(document).ready(function () {

			$('#jquery-wrapped-fine-uploader').fineUploader({
					request: {
					endpoint: '<?=base_url("admin/galleries/do_upload");?>',
					params: { 'gid' : '<?=$content['gid']?>'},
				},
				text: {
					uploadButton: 'Upload your images'
				},
				template:
					'<div class="qq-uploader span8 offset2">' +
					'<pre class="qq-upload-drop-area span12"><span>{dragZoneText}</span></pre>' +
					'<div class="qq-upload-button btn btn-success" style="width: auto;">{uploadButtonText}</div>' +
					'<span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>' +
					'<ul class="qq-upload-list" style="margin-top: 10px; text-align: center;"></ul>' +
					'</div>',
				classes: {
					success: 'alert alert-success',
					fail: 'alert alert-error'
				},
					debug: true
				});
		});
</script>