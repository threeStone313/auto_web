<div class="row">
	<article class="col-sm-12">
		<div class="data-block clearfix">
			<header>
				<h2><span class="elusive icon-folder-open"></span> Pack List</h2>
				<h2 class="pull-right"><a class="btn btn-inverse" href="<?php echo base_url( 'pack/add' )?>">Add One</a></h2>
			</header>
			<?php echo $notice;?>
			<!-- Navigation form -->
			<div class="col-sm-5" style="margin-top:10px">
			<?php echo form_open( 'pack/index', array('role'=>'search', 'method'=> 'get')); ?>
				<div class="input-group">
					<input type="text" id="search-pack" class="form-control" placeholder="Search Pack" name="s" value="<?php echo htmlspecialchars($search);?>">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-default"><span class="elusive icon-search"></span></button>
					</span>
				</div>
			</form>
			</div>
			<!-- /Navigation form -->
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="col-sm-5">Pack Name</th>
								<th>Tags</th>
								<th class="col-sm-3">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach( $datas as $pack ):?>
							<tr>
								<td><?php echo $pack['name'];?></td>
								<td><?php echo $pack['tags'];?></td>
								<td style="text-align:center;">
									<div class="btn-group">
										<span class="btn btn-sm" title="view" href="<?php echo base_url( 'pack/step_list/'.$pack['id'] )?>"><span class="elusive icon-eye-open"></span></span>
										<span class="btn btn-sm" title="edit" href="<?php echo base_url( 'pack/edit/'.$pack['id'] )?>"><span class="elusive icon-pencil"></span></span>
										<span class="btn btn-sm" title="delete" href="<?php echo base_url( 'pack/delete/'.$pack['id'] )?>"><span class="elusive icon-trash"></span></span>
									</div>
								</td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
					
				</div>
				<div class="pagination-right">
					<ul class="pagination"><?php echo $pagelinks;?></ul>
				</div>
		    </form>
			</div>
		</div>
	</article>
</div>
<script>
(function($){

	$('.btn-group .btn').on( 'click', function(){
		var self = $(this);
		if( self.attr('title') == 'delete' ) {
			if( confirm( 'Are you sure to delete this pack?' ) ){
				window.location = self.attr('href');
			} else {
				return false;
			}		
		} else {
			window.location = self.attr('href');
		}
	} );

	$('#search-pack').autocomplete( '/pack/ajax_pack_auto', {

			scrollHeight: 300,
	        matchContains: true,    
	        autoFill: false,
	        formatItem: function(row) {
	        	return row[1];
	        },
	        formatResult: function(row) {
				return row[1];
			}

		});
})(jQuery);
</script>