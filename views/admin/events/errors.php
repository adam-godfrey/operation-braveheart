<?php
	function Button($name) {
		global $buttons; // access the global $buttons array
		if(isset($buttons[$name])) {
			foreach($buttons[$name] as $attr_name => $attr_value)
				$attrs[] = sprintf('%s="%s"', $attr_name, $attr_value);
			return '<input type="button" '.implode(' ', $attrs).' />';
		}
		return;
	}
?>
<div class="box content_item">
	<div class="content_item_main">
		<div class="newsitem">
			<?php echo Form::open(array('enctype' => 'multipart/form-event', 'id' => 'adminForm', 'name' => 'adminForm', 'class' => 'form form-horizontal', 'action' => URL . 'admin/events/edit', 'method' => 'post', 'role' => 'form'));?>
			<div id="admin-buttons">
				<?php foreach ($this->buttons as $button): ?>
				<?php echo Button($button); ?>
				<?php endforeach; ?>
			</div>
			<?php if(isset($this->errors) && count($this->errors) > 0 ): ?>
			<h3 class="errorhead">There has been an error:</h3>
			<p><span class="bold">You forgot to enter the following field(s)</span></p>
			<ul id="validation">
				<?php foreach ($this->errors as $error): ?>
				<li><?=$error;?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
			<?php if(isset($this->success)) : ?>
			<?php if($this->success) : ?>
			<div id="form-submit" class="alert alert-success alert-dismissable">
				<button type="button" class="close" event-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Success!</strong> Event added.
			</div>
			<?php else: ?>
			<div id="form-submit" class="alert alert-danger alert-dismissable">
				<button type="button" class="close" event-dismiss="alert" aria-hidden="true">
					&times;
				</button>
				<strong>Error!</strong> Event not added.
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<fieldset>
				<legend><h2>EVENT INFORMATION</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="_title">TITLE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'event_title', 'id' => 'event_title', 'value' => $this->event['title']));?>
						<span class="help-block">Please enter a title for the fundraising event.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="events_content">CONTENT</label>
						<?php echo Form::textarea(array('rows' => '10', 'cols' => '50', 'class' => 'form-control text-input', 'name' => 'event_content', 'id' => 'event_content', 'value' => $this->event['content']));?>
						<span class="help-block">Please enter the content for the fundraising event.</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="event_keywords">KEYWORDS</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'event_keywords', 'id' => 'event_keywords', '' => 'Keywords / tags'));?>
						<span class="help-block">Please enter some keywords/search phrases for the event (optional).</span>
						<span class="help-block">Keywords/search phrases must be separated by commas.</span>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend><h2>EVENT LOCATION</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="location">LOCATION</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'location', 'id' => 'location', 'value' => $this->event['location']));?>
						<span class="help-block">Please enter a title for the events</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="postcode">POSTCODE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'postcode', 'id' => 'postcode', 'value' => $this->event['postcode']));?>
						<span class="help-block">Please enter the content for the events</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="latitude">LATITUDE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'latitude', 'id' => 'latitude', 'value' => '', 'value' => $this->event['latitude']));?>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="longitude">LONGITUDE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'longitude', 'id' => 'longitude', 'value' => '', 'value' => $this->event['longitude']));?>
						<span class="help-block">Please enter the event latitude/longitude co-ordinates or click on button to get co-ordinates automatically (requires postcode field to be filled in).</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<button type="button" class="btn btn-default" id="showmap">Launch modal</button>
					</div>
				</div>
			</fieldset>
			
			<fieldset>
				<legend><h2>EVENT DATE</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label" for="eventdate">EVENT DATE</label>
						<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'eventdate', 'id' => 'eventdatepicker', 'value' => $this->event['eventdate']));?>
						<span class="help-block">Please enter a select the date for the fundraising event (This will open a calendar).</span>
					</div>
				</div>
			</fieldset>
			
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'eventid', 'id' => 'eventid', 'value' => $this->event['eventid']));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'imgname', 'id' => 'imgname', 'value' =>  $this->event['imgname']));?>
			<?php echo Form::input(array('type' => 'hidden', 'name' => 'action', 'id' => 'action', 'value' => ''));?>
			<?php echo Form::close();?>
			
			<?php echo Form::open(array('enctype' => 'multipart/form-event', 'name' => 'uploadform', 'class' => 'form-horizontal', 'id' => 'uploadform', 'action' => URL . 'util/processupload.php', 'method' => 'post', 'role' => 'form'));?>
			<fieldset>
				<legend><h2>Event Image</h2></legend>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<label class="control-label">IMAGE TO UPLOAD</label>
						<div class="input-group">
							<span class="input-group-btn">
								<span class="btn btn-default btn-file">
									Browse&hellip; <?php echo Form::input(array('type' => 'file', 'class' => '', 'name' => 'filepic', 'id' => 'filepic'));?>
								</span>
							</span>
							<?php echo Form::input(array('type' => 'text', 'class' => 'form-control text-input', 'name' => 'image-file', 'id' => 'image-file', 'readonly' => ''));?>
							<?php echo Form::input(array('type' => 'hidden', 'name' => 'destination', 'id' => 'destination', 'value' => 'content'));?>
						</div>
						<span class="help-block">Please select an image for the event (optional).</span>
					</div>
				</div>
				<div class="col-md-8 col-md-offset-2">
					<div class="form-group">
						<?php echo Form::input(array('type' => 'submit', 'id' => 'SubmitButton', 'name' => 'SubmitButton', 'value' => ' '));?>
					</div>
				</div>
			</fieldset>
			<?php echo Form::close();?>
			<div class="col-md-8 col-md-offset-2">
				<div class="progress progress-striped">
					<div id="progressbar" class="progress-bar progress-bar-warning" style="width: 0%">
						<span id="statustxt" class="sr-only">0% Complete</span>
					</div>
				</div>
			</div>
			<div id="output">
				<img id="preview-img" class="img-responsive" src="<?=URL;?>public/images/content/<?=$this->event['image'];?>" alt="<?=$this->event['alternate'];?>" title="<?=$this->event['alternate'];?>">
			</div>
		</div>
	</div>
</div>