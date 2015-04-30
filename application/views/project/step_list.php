<div class="row">
	<article class="col-sm-12">
		<div class="data-block clearfix">
			<header>
				<h2><span class="elusive icon-folder-open"></span> Step List (Current Case : <?php echo $case_name;?>)</h2>
				<h2 class="pull-right"><a class="btn btn-inverse" href="<?php echo base_url( 'project/case_list/'.$_SESSION['project_id'] )?>">Go back</button></a>
			</header>
			<?php echo $notice;?>
			<div class="col-sm-12">
			<?php echo form_open( '', array('role'=>'form', 'id'=>'myform')); ?>
				<div class="table-responsive">
					<table class="table table-striped table-hover table-media main-table">
						<thead>
							<tr>
								<th class="">Order</th>
								<th>CheckPoint</th>
								<th class="col-sm-2">Action</th>
								<th class="col-sm-2">Locator</th>
								<th>Element</th>
								<th>Alias</th>
								<th>Data</th>
								<th class="col-sm-1"><div class="btn btn-sm add_one" title="add" href="#"><span class="elusive icon-plus"></span></div></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach( $datas as $v):?>
							<tr>
								<td><input type="text" class="form-control orderby" name="step[<?php echo $v['id']?>][orderby]" value="<?php echo intval( $v['orderby'] ); ?>"></td>
								<td><input type="text" class="form-control" name="step[<?php echo $v['id']?>][checkpoint]" value="<?php echo htmlspecialchars( $v['checkpoint'] );?>"></td>

								<?php if( $v['pack_id'] ):?>

								<td colspan="5" class="packstep">Referenced steps pack: <a href="/pack/step_list/<?php echo $v['pack_id'];?>" target="_blank"><?php echo htmlspecialchars( $v['pack_name'] );?></a></td>

								<?php else: ?>

								<td><?php echo getSelectForm( 'step_action', 'step['.$v['id'].'][action]', $v['action']); ?></td>
								<td><?php echo getSelectForm( 'step_locator', 'step['.$v['id'].'][locator]', $v['locator']); ?></td>
								<td><input type="text" class="form-control" name="step[<?php echo $v['id']?>][element]" value="<?php echo htmlspecialchars( $v['element'] );?>"></td>
								<td><input type="text" class="form-control alias" name="step[<?php echo $v['id']?>][alias]" value="<?php echo htmlspecialchars( $v['alias'] ); ?>"></td>
								<td><input type="text" class="form-control" name="step[<?php echo $v['id']?>][data]" value="<?php echo htmlspecialchars( $v['data'] ); ?>"></td>

								<?php endif;?>
								<td style="text-align:center;">
									<div class="btn-group">
										<div class="btn btn-sm add_one" title="add" href="#"><span class="elusive icon-plus"></span></div>
										<div class="btn btn-sm del_one" title="edit" href="#"><span class="elusive icon-minus"></span></div>
									</div>									
								</td>
								</tr>
						<?php endforeach;?>
						</tbody>
					</table>
					
				</div>
				<div class="form-group">
					<input class="btn btn-info mysubmit" type="button" style="margin-bottom:10px;" name="save" value="Save" uri="<?php echo 'project/step_save/'.$_SESSION['case_id'];?>">
					<input class="btn btn-info" type="button"  data-toggle="modal" href="#demoModal" style="margin-bottom:10px;" name="save" value="Insert Pack Step">
				</div>	
		    </form>
			</div>
		</div>
	</article>
</div>
<!-- Modal demo - modal window -->
<div class="modal primary fade" id="demoModal">

	<!-- Modal dialog -->
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Packs</h4>
			</div>
			<!-- /Modal header -->

			<!-- Modal body -->
			<div class="modal-body clearfix">
				<div class="col-sm-12">
					<div class="input-group">
						<input type="text" class="form-control search-input" placeholder="Search Pack" name="s" value="">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default search-button"><span class="elusive icon-search"></span></button>
						</span>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="table table-striped table-hover table-media pack-list">
							<thead>
								<tr>
									<th>&nbsp;&nbsp;&nbsp;</th>
									<th>Pack Name (order by using times)</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($pack_list as $key => $value): ?>
								<tr>
									<td><input type="radio" class="form-control" name="pack" data-id="<?php echo $value['id']?>"></td>
									<td class="packstep"><?php echo htmlspecialchars( $value['name'] );?></td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
						
					</div>
				</div>
			</div>
			<!-- /Modal body -->

			<!-- Modal footer -->
			<div class="modal-footer">
				<p class="alert" style="display:none;">Please select one.</p>
				<button type="button" class="btn btn-primary pack-insert" data-dismiss="modal" >Insert</button>
			</div>
			<!-- /Modal footer -->

		</div>
	</div>
	<!-- /Modal dialog -->

</div>
<!-- /Modal demo - modal window -->
<script>
(function($){

	//submit to different action
	$('.mysubmit.btn').on('click', function(){
		var action = 'http://'+ window.location.host + '/' + $(this).attr('uri');
			form = document.getElementById('myform');
		form.action = action;
		form.submit();
	});


	$('.pack-list').on('click','input:radio', function(){
		$('.modal-footer .alert').hide();
	});
	//submit to different action
	$('.pack-insert.btn').on('click', function(){

		var id = $('.pack-list input:checked').attr('data-id');
		if( !id ) {
			$('.modal-footer .alert').show();
			return false;
		}

		var	name = $('.pack-list input:checked').closest('td').next('td').text(),
			s = '',
			len = $('.main-table tr').length;
		
		
		s += '<tr>';
		s += '<td><input type="text" class="form-control orderby" name="add['+len+'][orderby]" value="'+ len +'"></td>';
		s += '<td><input type="text" class="form-control" name="add['+len+'][checkpoint]" value=""></td>';
		s += '<td colspan="5" class="packstep"><input type="hidden" class="form-control" name="add['+len+'][pack_id]" value="'+id+'"><input type="hidden" class="form-control" name="add['+len+'][action]" value="18">Referenced steps pack: <a href="/pack/step_list/'+id+'" target="_blank">'+name+'</a></td>';
		s += '<td style="text-align:center;">';
		s += '<div class="btn-group">';
		s += '<div class="btn btn-sm add_one" title="add" href="#"><span class="elusive icon-plus"></span></div>';
		s += '<div class="btn btn-sm del_one" title="edit" href="#"><span class="elusive icon-minus"></span></div></td>';
		s += '</div>';
		s += '</td>';
		s += '</tr>'; 
		$('.main-table').append(s);
	});

	$('.search-button').on('click',function(){

		var packname = $('.search-input').val();
		if( packname == '') {
			return false;
		}

		$.post('/pack/ajax_search',{ name : packname }, function( data ){
			data = eval('('+data+')');
			var s = '';
			for( var i=0; i< data.length; i++) {
				s += '<tr>';
				s += '<td><input type="radio" class="form-control" name="pack" data-id="'+data[i].id+'"></td>'
				s += '<td><a class="btn btn-link" href="/pack/step_list/'+data[i].id+'" target="_blank">'+data[i].name+'</a></td>'
				s += '</tr>';
			}

			$('.pack-list tbody').html( s );
		});
	});


	$('.main-table').on('click', '.add_one', function(){

		var s = '',
			self = $(this),
			len = $('.main-table tr').length;
		$.get( '/project/ajax_get_step_data', function( data ){
			data = eval('('+data+')');
			
			s += '<tr>';
			s += '<td><input type="text" class="form-control orderby" name="add['+len+'][orderby]" value="'+ len +'"></td>';
			s += '<td><input type="text" class="form-control" name="add['+len+'][checkpoint]" value=""></td>';
			s += '<td>' + getSelectForm( data.action , 'add['+len+'][action]' ) + '</td>';
			s += '<td>' + getSelectForm( data.locator , 'add['+len+'][locator]' ) + '</td>';
			s += '<td><input type="text" class="form-control" name="add['+len+'][element]" value=""></td>';
			s += '<td><input type="text" class="form-control alias" name="add['+len+'][alias]" value=""></td>';
			s += '<td><input type="text" class="form-control" name="add['+len+'][data]" value=""></td>';
			s += '<td style="text-align:center;">';
			s += '<div class="btn-group">';
			s += '<div class="btn btn-sm add_one" title="add" href="#"><span class="elusive icon-plus"></span></div>';
			s += '<div class="btn btn-sm del_one" title="edit" href="#"><span class="elusive icon-minus"></span></div></td>';
			s += '</div>';
			s += '</td>';
			s += '</tr>';
			self.closest('tr').after(s);

			blindAutoComplete();
			resetOrder();
		});
		
	});

	$('.main-table').on( 'click', '.del_one', function(){
		$(this).closest('tr').remove();
		resetOrder();
	} );

	function getSelectForm( data, name ) {

		var s='';
		s += '<select class="form-control" name="' + name +'" >';
		for( key in data ) {
			s += '<option value="'+key+'" >'+ data[key] +'</option>';
		}
		s += '</select>';
		return s;
	}

	function resetOrder(){
		$('.orderby').each(function( i ){
			$(this).val( i+1 );
		});
	}

	function blindAutoComplete() {
		
		$('.alias').autocomplete( '/ele_repository/ajax_autocomplete', {

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
	}

	$('.search-input').autocomplete( '/pack/ajax_pack_auto', {

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


	blindAutoComplete();

})(jQuery);
</script>