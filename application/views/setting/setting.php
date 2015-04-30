<?php echo $notice;?>
<div class="row">
	
	<div class="col-sm-12">
		<h4>Account setting</h4>
		<?php echo form_open('setting/save_detail', array('role'=>'form', 'class'=>'form-horizontal')); ?>
			<div class="form-group">
				<label class="col-sm-3 control-label">Datebase Url</label>
				<div class="col-sm-5">
					<input type="text" placeholder="Datebase Url" class="form-control" name="sqlUrl" value="<?php echo element('sqlUrl', $setting, '');?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Datebase User</label>
				<div class="col-sm-5">
					<input type="text" placeholder="Datebase User" class="form-control" name="sqlAccount" value="<?php echo element('sqlAccount', $setting, '');?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Datebase Password</label>
				<div class="col-sm-5">
					<input type="text" placeholder="Datebase Password" class="form-control" name="sqlPassword" value="<?php echo element('sqlPassword', $setting, '');?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="submit" class="btn btn-lg btn-primary">Save changes</button>
				</div>
			</div>
		</form>
	</div>
	<div class="col-sm-12">
		<h4>Change password</h4>
		<?php echo form_open('admin/change_password', array('role'=>'form', 'class'=>'form-horizontal')); ?>
			<div class="form-group">
				<label class="col-sm-3 control-label">New Password</label>
				<div class="col-sm-5">
					<input type="password" class="form-control" name="password">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Confirm Password</label>
				<div class="col-sm-5">
					<input type="password" class="form-control" name="passwordconf">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
					<button type="submit" class="btn btn-lg btn-primary">Change password</button>
				</div>
			</div>
		</form>
	</div>
</div>