<section id="content" class="col-sm-12">
				<div class="editAccount">
					
					<form autocomplete="off" id='create_order'   action="<?php echo base_url();?>orders/create_order" method="post" class="add_customer_form">
						<div class="form-group">
							<div class="col-sm-10 offset-sm-2">
								<h3>Add New Order</h3>
							</div>
							<div class="col-sm-12">
								<?php if($this->session->flashdata('errorMsg')){ ?>
								<div class="alert alert-danger alert-dismissible">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>Error!</strong><?php echo $this->session->flashdata('errorMsg'); ?>
								</div>
								<?php } ?>
								<?php if($this->session->flashdata('successMsg')){ ?>
								<div class="alert alert-success alert-dismissible">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>Success!</strong><?php echo $this->session->flashdata('successMsg'); ?>
								</div>
								<?php } ?>
								
							</div>
						</div>
						<div class="row form-group">
						<input type="hidden" name="modFlag" id="modFlag" value="0" />


							<div class="col-sm-3 text-right">
								Date:
							</div>
							<div class="col-sm-1">
							<?php $nowTime  = time(); ?>
								<input id="month" onkeyup="removeNonDigit(this.id);  dateMod('<?php echo date('m',$nowTime)?>-<?php echo date('d',$nowTime)?>-<?php echo date('Y',$nowTime)?>');"  type="text" value="<?php echo date('m',$nowTime)?>"  name="month"   class="form-control" />
							</div>
							<div class="col-sm-1">
								<input id="date" onkeyup="removeNonDigit(this.id);  dateMod('<?php echo date('m',$nowTime)?>-<?php echo date('d',$nowTime)?>-<?php echo date('Y',$nowTime)?>');" type="text" value="<?php echo date('d',$nowTime)?>" name="date"  class="form-control" />
							</div>
							<div class="col-sm-2">
								<input   id="year" onkeyup="removeNonDigit(this.id);  dateMod('<?php echo date('m',$nowTime)?>-<?php echo date('d',$nowTime)?>-<?php echo date('Y',$nowTime)?>');" type="text" value="<?php echo date('Y',$nowTime)?>" name="year"  class="form-control" />
								<span id="date_mod_display"></span>
							</div>
							
							<div class="col-sm-3 text-right">
								Total Page Count:
							</div>
							<div class="col-sm-2">
								<input id="grandtotal" readonly="readonly" type="text" value="" name="grandtotal"  class="form-control" />
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Project Name:
							</div>
							<div class="col-sm-4">
								<input type="text" value=""  id ='proname' name="proname"  class="form-control" />
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
									Discount($ / page) : <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<input type="text"  value=""  id ='order_discount' name="order_discount" class="form-control" />
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('order_discount', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Customer: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<select name="customer"  id="customer" class="form-control">
									<option value="" selected>Select a customer</option>
									<?php foreach ($allCust as $cust) { ?>
									<option value="<?php echo $cust['cust_id']; ?>"  ><?php echo stripslashes( "{$cust['cust_name']} - {$cust['cust_comp']}" ); ?> </option> 
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-5">
								<a type="button" class="btn btn-primary" href="<?php echo base_url();?>customers/add" id="addredd_link">Add Customer</a>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_country', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								CSR: <span class="text-danger">*</span>
							</div>
							<div class="col-sm-4">
								<select name="csrep"  id="csrep" class="form-control">
									<option value="" selected>Select a CSR</option>
									<?php foreach ($allCSR as $csr) { ?>
									<option value="<? echo $csr['user_id'] ?>" ><?php echo $csr["user_fname"].' '.$csr["user_lname"]?> </option> 
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-12 offset-sm-3">
								<?php echo form_error('cust_country', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Use manual billing  : 
							</div>
							<div class="col-sm-1">
								<input type="checkbox" name="check_name"  value="Y"  class="form-control"  />
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-sm-3 text-right">
								Rush Project? :  
							</div>
							<div class="col-sm-1">
								<input type="checkbox" name="rush_charge"  value="Y" class="form-control"  />
								
								<input type="hidden" name="rush_val" id="rush_val" value="<?php echo DEFAULTRUSH; ?>">
							</div>
							<div class="col-sm-3">
							
								(+<span id="openPrompt" class="orderdetails1">$<span id="changeVal"><?php echo DEFAULTRUSH; ?></span> per page</span>)
							</div>
							
						</div>
						<div id='talentDv'>
							<div class="row form-group talentcount">
								<div class="col-sm-3 text-right">
									Talent #1: <span class="text-danger">*</span>
								</div>
								<div class="col-sm-4">
									<select name="talent_1"  id="talent_1" class="form-control">
										<option value="" selected>Select talent</option>
										<?php echo $alltlnt; ?>
									</select>
								</div>
								
							</div>
							<div class="row">
								<div class="col-sm-6 text-center">
									<label class="upload">Upload Scripts</label>
									<a href="#" id="demo-attach">Attach a file</a> 
									<ul id="demo-list"></ul> 
									<a href="#" id="demo-attach-2" style="display: none;">Attach another file</a>
									
								</div>
								<div class="col-sm-2 text-left">
									Script Page Count : 
									<input type="hidden" name="script_count_1" id="script_count_1" />
									<input type="hidden" id="sumcount_1" name="sumcount_1" value="0" />									
								</div>
								
							</div>
						</div>
						<input type="hidden" name="total_talent"  id="total_talent" value="1" />
						<hr size="20">
						<div class="row form-group">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 float-right">
								<a id="addAnotherTlnt" href="javascript:void(0)">Add another talent</a>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<button type="submit" class="btn btn-info" value="Save" ><i class="fas fa-save"></i> Save</button>
								<a href="<?php echo base_url();?>customers" class="btn btn-outline-info"><i class="fas fa-arrow-left"></i> Back</a>
							</div>
						</div>
					</form>
				</div>
		</section>
<script language="javascript" type="text/javascript">
  jQuery.noConflict();
</script>

<script src="<?php echo base_url();?>assets/js/fancy-upload/mootools.js"></script>
<script src="<?php echo base_url();?>assets/js/fancy-upload/Fx.ProgressBar.js"></script>
<script src="<?php echo base_url();?>assets/js/fancy-upload/Swiff.Uploader.js"></script>
<script src="<?php echo base_url();?>assets/js/fancy-upload/FancyUpload3.Attach.js"></script>
<script src="<?php echo base_url();?>assets/js/fancy-upload/Lang.js"></script>


<script type="text/javascript">
var genId = '';
/**
 * FancyUpload Showcase
 *
 * @license		MIT License
 * @author		Harald Kirschner <mail [at] digitarald [dot] de>
 * @copyright	Authors
 */
 

 
window.addEvent('domready', function() {

	/**
	 * Uploader instance
	 */
	var up = new FancyUpload3.Attach('demo-list', '#demo-attach, #demo-attach-2', {
		path: '<?php echo base_url();?>assets/js/fancy-upload/Swiff.Uploader.swf',
		url: '<?php echo base_url();?>assets/js/fancy-upload/server-2/script.php',
		fileSizeMax: 2 * 1024 * 1024,
		idIndex : 1,
		verbose: true,
 
		onSelectFail: function(files) {
			files.each(function(file) {
				new Element('li', {
					'class': 'file-invalid',
					events: {
						click: function() {
							this.destroy();
						}
					}
				}).adopt(
					new Element('span', {html: file.validationErrorMessage || file.validationError})
				).inject(this.list, 'bottom');
			}, this);	
		},
 
		onFileSuccess: function(file) {
			
                    if(isDuplcateiFile(file.name)){
                        file.ui = file.ui.element.destroy();
                        tlntFlag = genId.split("_")[0];
                        calcTotalPage(tlntFlag)
                        alert(file.name+' already uploaded!\nPlease upload a different file.');
                    }
                    else{
						new Element('img', {'src': '../assets/images/delete_icon.gif', 'width': '20', 'height':'16', 'border':'0', 'id': 'del_'+genId, 'onclick': "delScript('"+genId+"')",  'style':'float: left; cursor: pointer; padding-right:10px;' }).inject(file.ui.element, 'top');
						file.ui.element.highlight('#e6efc2');
						
                    }
			
		},
		
		onComplete: function() {

			this.ui.pages = new Element('input', {'class': 'file-title','type' :'text', 'value': '', 'name' : 'page-cout_'+genId,  id: 'page-cout_' + genId, 'onkeyup': 'calcTotalPage("'+this.special+'");', 'onblur': 'calcTotalPage("'+this.special+'");', 'style': 'width: 50px; height:16px;'});

			this.ui.element.adopt(

				this.ui.pages

			).inject(this.base.list).highlight();

			if (this.response.error) {

				var msg = MooTools.lang.get('FancyUpload', 'errors')[this.response.error] || '{error} #{code}';

				this.errorMessage = msg.substitute($extend({name: this.name}, this.response));

				

				this.base.fireEvent('fileError', [this, this.response, this.errorMessage]);

				this.fireEvent('error', [this, this.response, this.errorMessage]);

				return;

			}

			

			if (this.ui.progress) this.ui.progress = this.ui.progress.cancel().element.destroy();

			this.ui.cancel = this.ui.cancel.destroy();

			

			var response = this.response.text || '';

			this.base.fireEvent('fileSuccess', [this, response]);

					

		},
 
		onFileError: function(file) {
			file.ui.cancel.set('html', 'Retry').removeEvents().addEvent('click', function() {
				file.requeue();
				return false;
			});
 
			new Element('span', {
				html: file.errorMessage,
				'class': 'file-error'
			}).inject(file.ui.cancel, 'after');
		},
 
		onFileRequeue: function(file) {
			file.ui.element.getElement('.file-error').destroy();
 
			file.ui.cancel.set('html', 'Cancel').removeEvents().addEvent('click', function() {
				file.remove();
				return false;
			});
 
			this.start();
		}
 
	});
 
});
	
	
FancyUpload3.Attach.File = new Class({
	Extends: Swiff.Uploader.File,
	render: function() {
		if (this.invalid) {
			if (this.validationError) {
				var msg = MooTools.lang.get('FancyUpload', 'validationErrors')[this.validationError] || this.validationError;
				this.validationErrorMessage = msg.substitute({
					name: this.name,
					size: Swiff.Uploader.formatUnit(this.size, 'b'),

					fileSizeMin: Swiff.Uploader.formatUnit(this.base.options.fileSizeMin || 0, 'b'),

					fileSizeMax: Swiff.Uploader.formatUnit(this.base.options.fileSizeMax || 0, 'b'),

					fileListMax: this.base.options.fileListMax || 0,

					fileListSizeMax: Swiff.Uploader.formatUnit(this.base.options.fileListSizeMax || 0, 'b')

				});

			}

			this.remove();

			return;

		}

		

		this.addEvents({

			'open': this.onOpen,

			'remove': this.onRemove,

			'requeue': this.onRequeue,

			'progress': this.onProgress,

			'stop': this.onStop,

			'complete': this.onComplete,

			'error': this.onError

		});

		

		this.ui = {};

		this.special = this.base.options.idIndex;

		genId  = this.special+'_'+this.id;

	
		document.getElementById('script_count_'+this.special).value=this.id;

		

		this.ui.element = new Element('li', {'class': 'file', id: 'file-' + genId, 'style' : 'line-height: 16px; padding: 4px 10px 4px 0px;', 'onmouseover':'backgroundHover(this)', 'onmouseout': 'backgroundOutWhite(this)'});

		this.ui.title = new Element('div', {'class': 'file-title', text: this.name+' -- '+Swiff.Uploader.formatUnit(this.size, 'b'),  id: 'file-title_' + genId, 'style':'width:315px; height:16px; float: left;'});

		this.ui.size = new Element('span', {'class': 'file-size', text: '' , 'style':'float:left'});

		this.ui.filename = new Element('input', {'class': 'file-title','type' :'hidden', 'value': this.name, 'name' : 'file-titleH_'+genId,  id: 'file-titleH_' + genId});

		//this.ui.pages = new Element('input', {'class': 'file-title','type' :'text', 'value': '', 'name' : 'page-cout_'+genId,  id: 'page-cout_' + genId, 'onkeyup': 'calcTotalPage("'+this.special+'");', 'style': 'width: 50px; height:16px;'});  // 'onblur': 'calcTotalPage("'+this.special+'");',

		

		this.ui.cancel = new Element('a', {'class': 'file-cancel', text: 'Cancel', href: '#'});

		this.ui.cancel.addEvent('click', function() {

			this.remove();

			return false;

		}.bind(this));

		

		this.ui.element.adopt(

			this.ui.title,

			this.ui.size,

			this.ui.filename,

			this.ui.cancel

		).inject(this.base.list).highlight();



		

		var progress = new Element('img', {'class': 'file-progress', src: '../include/fancy-upload/assets/progress-bar/bar.gif'}).inject(this.ui.size, 'after');

		this.ui.progress = new Fx.ProgressBar(progress, {

			fit: true

		}).set(0);

					

		this.base.reposition();



		return this.parent();

	},



	onOpen: function() {

                this.ui.element.addClass('file-uploading');

                if (this.ui.progress) this.ui.progress.set(0);             

	},



	onRemove: function() {

		this.ui = this.ui.element.destroy();

	},



	onProgress: function() {

		if (this.ui.progress) this.ui.progress.start(this.progress.percentLoaded);

	},



	onStop: function() {

		this.remove();

	},

	

	onComplete: function() {

		this.ui.pages = new Element('input', {'class': 'file-title','type' :'text', 'value': '', 'name' : 'page-cout_'+genId,  id: 'page-cout_' + genId, 'onkeyup': 'calcTotalPage("'+this.special+'");', 'onblur': 'calcTotalPage("'+this.special+'");', 'style': 'width: 50px; height:16px;'});

		this.ui.element.adopt(

			this.ui.pages

		).inject(this.base.list).highlight();

		if (this.response.error) {

			var msg = MooTools.lang.get('FancyUpload', 'errors')[this.response.error] || '{error} #{code}';

			this.errorMessage = msg.substitute($extend({name: this.name}, this.response));

			

			this.base.fireEvent('fileError', [this, this.response, this.errorMessage]);

			this.fireEvent('error', [this, this.response, this.errorMessage]);

			return;

		}

		

		if (this.ui.progress) this.ui.progress = this.ui.progress.cancel().element.destroy();

		this.ui.cancel = this.ui.cancel.destroy();

		

		var response = this.response.text || '';

		this.base.fireEvent('fileSuccess', [this, response]);

                

	},



	onError: function() {

		this.ui.element.addClass('file-failed');		

	}



});
function backgroundHover (ele){
	
}
function backgroundOutWhite(ele){
	
}
</script>
	<script type="text/javascript">
		
			jQuery(document).ready(function(){
				
				jQuery("#addAnotherTlnt").click(function(){
					if(parseInt(document.getElementById('total_talent').value)>0 && !checkScript()) return false;
					var id=jQuery('.talentcount').length+1;
					var talentoption ='<?php echo $alltlnt; ?>';
					var html = '<div class="row form-group talentcount">'+
									'<div class="col-sm-3 text-right">Talent #'+id+':'+
									'</div>'+
								'<div class="col-sm-4">'+
								'<select name="talent_'+id+'" id="talent_'+id+'" class="form-control">'+
									'<option value="" selected>Select talent</option>'+
									talentoption +	
								'</select></div></div>'+
								'<div  class="row"><div class="col-sm-6 text-center">'+
								'<a href="#" id="demo-attach_'+id+'">Attach a file</a>'+ 
									'<ul id="demo-list_'+id+'"></ul>'+ 
									'<a href="#" id="demo-attach'+id+'-2" style="display: none;">Attach another file</a>'+
								'</div><div class="col-sm-2 text-left">Script Page Count :'+									 
									'<input type="hidden" name="script_count_'+id+'" id="script_count_'+id+'" />'+	
									'<input type="hidden" id="sumcount_'+id+'" name="sumcount_'+id+'" value="0" />'+								
								'</div>'+
							'</div>';
					jQuery( "#total_talent" ).val(id);	
					jQuery( "#talentDv" ).append(html);
					addNewTalentEvent(id);
								
				})
				
				jQuery( "#openPrompt" ).click(function(){
						swal({
					  title: "Please Enter Rush Charge",
					  text: false,
					  type: "input",
					  showCancelButton: true,
					  confirmButtonClass: "btn-danger",
					  confirmButtonText: "Submit",
					  cancelButtonText: "Cancel",
					  closeOnConfirm: false
					},
					function(inputValue){
						if(inputValue){				
						 jQuery('#rush_val').val(inputValue);
						 jQuery('#changeVal').html(inputValue);
						 
						swal.close();
						}else{
							swal.close();
							return false;
						}
					});
				})
				jQuery( "#create_order" ).submit(function( event ) {
					var month=document.getElementById('month').value;
					var date=document.getElementById('date').value;
					var year=document.getElementById('year').value;
					var proname=document.getElementById('proname').value;
					var order_discount=document.getElementById('order_discount').value;
					var customer=document.getElementById('customer').value;
					var csrep=document.getElementById('csrep').value;
					
					if	(month==null || month.trim()==""){
						
						alert('Please Enter Month !');
						 event.preventDefault();
						 return false;
					}
				
					if	(month.isNaN == true ){
						alert('Please Enter Month As Numeric Character!');
						 event.preventDefault();
						 return false;
					}
					if	(date==null || date.trim()==""){
						alert('Please Enter Date!');
						 event.preventDefault();
						 return false;
					}
					if	(date.isNaN == true ){
						alert('Please Enter Date As Numeric Character!');
						 event.preventDefault();
						 return false;
					}
					if	(year==null || year.trim()=="" ){
						alert('Please Enter Year!');
						 event.preventDefault();
						 return false;
					}
					if	(year.isNaN == true){
						alert('Please Enter Year As Numeric Character!');
						 event.preventDefault();
						 return false;
					}
					if	(proname==null || proname.trim()==""){
						alert('Please Enter Project Name !');
						 event.preventDefault();
						 return false;
					}						
					if	(proname==null || proname.trim()==""){
						alert('Please Enter Project Name !');
						 event.preventDefault();
						 return false;
					}
					if	(order_discount.isNaN == true){
						alert('Please Enter Numeric Value for discount !');
						 event.preventDefault();
						 return false;
					}
					if	(customer==null || customer.trim()==""){
						alert('Please Enter Customer Name !');
						 event.preventDefault();
						 return false;
					}
					if	(csrep==null || csrep.trim()==""){
						alert('Please Enter Customer Service Representative Name !');
						 event.preventDefault();
						 return false;
					}
				 
				});
			});

			
		function addNewTalentEvent(id){
				
			var domlist='demo-list_'+id
			var domeattache='#demo-attach_'+id+', #demo-attach'+id+'-2';
				 
		 window.addEvent('domready', function() {

		/**
		 * Uploader instance
		 */
		var up = new FancyUpload3.Attach(domlist, domeattache, {
			path: '<?php echo base_url();?>assets/js/fancy-upload/Swiff.Uploader.swf',
			url: '<?php echo base_url();?>assets/js/fancy-upload/server-2/script.php',
			fileSizeMax: 2 * 1024 * 1024,
			idIndex : id,
			verbose: true,
	 
			onSelectFail: function(files) {
				files.each(function(file) {
					new Element('li', {
						'class': 'file-invalid',
						events: {
							click: function() {
								this.destroy();
							}
						}
					}).adopt(
						new Element('span', {html: file.validationErrorMessage || file.validationError})
					).inject(this.list, 'bottom');
				}, this);	
			},
	 
			onFileSuccess: function(file) {
						if(isDuplcateiFile(file.name)){
							file.ui = file.ui.element.destroy();
							tlntFlag = genId.split("_")[0];
							calcTotalPage(tlntFlag)
							alert(file.name+' already uploaded!\nPlease upload a different file.');
						}
						else{
							new Element('img', {'src': '../assets/images/delete_icon.gif', 'width': '20', 'height':'16', 'border':'0', 'id': 'del_'+genId, 'onclick': "delScript('"+genId+"')",  'style':'float: left; cursor: pointer; padding-right:10px;' }).inject(file.ui.element, 'top');
							file.ui.element.highlight('#e6efc2');
							
						}
				
			},
			onComplete: function() {
					

			this.ui.pages = new Element('input', {'class': 'file-title','type' :'text', 'value': '', 'name' : 'page-cout_'+genId,  id: 'page-cout_' + genId, 'onkeyup': 'calcTotalPage("'+this.special+'");', 'onblur': 'calcTotalPage("'+this.special+'");', 'style': 'width: 50px; height:16px;'});

			this.ui.element.adopt(

				this.ui.pages

			).inject(this.base.list).highlight();

			if (this.response.error) {

				var msg = MooTools.lang.get('FancyUpload', 'errors')[this.response.error] || '{error} #{code}';

				this.errorMessage = msg.substitute($extend({name: this.name}, this.response));

				

				this.base.fireEvent('fileError', [this, this.response, this.errorMessage]);

				this.fireEvent('error', [this, this.response, this.errorMessage]);

				return;

			}

			

			if (this.ui.progress) this.ui.progress = this.ui.progress.cancel().element.destroy();

			this.ui.cancel = this.ui.cancel.destroy();

			

			var response = this.response.text || '';

			this.base.fireEvent('fileSuccess', [this, response]);

					

		},
			onFileError: function(file) {
				file.ui.cancel.set('html', 'Retry').removeEvents().addEvent('click', function() {
					file.requeue();
					return false;
				});
	 
				new Element('span', {
					html: file.errorMessage,
					'class': 'file-error'
				}).inject(file.ui.cancel, 'after');
			},
	 
			onFileRequeue: function(file) {
				file.ui.element.getElement('.file-error').destroy();
	 
				file.ui.cancel.set('html', 'Cancel').removeEvents().addEvent('click', function() {
					file.remove();
					return false;
				});
	 
				this.start();
			}
	 
		});
	 
	});
 }
			function removeNonDigit(id)
			{
				inputE = document.getElementById(id);	
				tmp = inputE.value.replace(/\D/gi,'');
				inputE.value = tmp;
				inputE.focus();
			}
			function dateMod(presentVal)
			{
				isDateMod = false;
				
				nowTimeArr = presentVal.split('-');
				//alert(parseInt(jQuery('#month').val()) +'!='+ parseInt(nowTimeArr[0]) +':'+  parseInt(jQuery('#date').val()) +'!='+ parseInt(nowTimeArr[1]) +':'+  parseInt(jQuery('#year').val()) +'!='+ parseInt(nowTimeArr[2]) )
				//tmp = parseInt(jQuery('#date').val()) +' : '+ parseInt('08') +' : '+nowTimeArr ;
				if( parseInt(parseFloat(jQuery('#month').val())) != parseInt(parseFloat(nowTimeArr[0])) ||  parseInt(parseFloat(jQuery('#date').val())) != parseInt(parseFloat(nowTimeArr[1])) ||  parseInt(parseFloat(jQuery('#year').val())) != parseInt(parseFloat(nowTimeArr[2])) )
				{
					document.getElementById('modFlag').value=1;	
					jQuery('#date_mod_display').text('MD');
				}
				else
				{
					document.getElementById('modFlag').value=0;
					jQuery('#date_mod_display').text('');
				}
				//jQuery('#date_mod_display').text(tmp);
			}
			
			function isDuplcateiFile(thisFileName){		
				var dupliFiles = jQuery("[id^='file-titleH_'][value='"+thisFileName+"']");
				if(dupliFiles.length > 1){
					return true;

				}
				return false;

			}
			
			function calcTotalPage(id_suffix)
			{
			totScript = parseInt(document.getElementById('script_count_'+id_suffix).value);			
			totPageCount = 0;
			for(loop = 1; loop <= totScript;loop++)
			{
				pageElement = document.getElementById('page-cout_'+id_suffix+'_'+loop);
				if(pageElement)
				{
					page = pageElement.value;
					tmp = page.search(/[^0-9]/);
					if(tmp >= 0 && page.length > 0)
					{
						alert('Only digits are allowed');
						page = page.replace(/\D/gi,'');
						pageElement.focus();
						pageElement.value = page;

					}			

					totPageCount += page? parseInt(page):0;

				}
			}

			document.getElementById('sumcount_'+id_suffix).value = totPageCount;
			pageGrandTotal = 0;
			tlntT = parseInt(document.getElementById('total_talent').value);
			console.log(tlntT);
			for(i=1 ; i <= tlntT; i++)
			{
				subTotalE = document.getElementById('sumcount_'+i);
				if(subTotalE)
				{
					pageGrandTotal += parseInt(subTotalE.value);	

				}
			}

			document.getElementById('grandtotal').value = pageGrandTotal;

		}

		function checkScript()

{

	totTlnt = parseInt(document.getElementById('total_talent').value);

	tlntCount = 0;

	for(id_suffix = 1; id_suffix <= totTlnt;id_suffix++)

	{

		tlntListElement = document.getElementById('talent_'+id_suffix);

		if(tlntListElement)

		{

			tnltId = parseInt(tlntListElement.value);

			if(!tnltId)

			{

				alert('Choose a talent');	

				tlntListElement.focus();

				return false;

			}

			tlntCount++;

		}

		

		pageElement = document.getElementById('script_count_'+id_suffix);

		if(pageElement)

		{

			page = parseInt(pageElement.value);

			if(!page)

			{

				alert('Attach scripts for this talent');	

				//tlntListElement.focus();

				document.getElementById('demo-attach_'+id_suffix).focus();

				return false;

			}

			else

			{

				for(loop = 1; loop <= page;loop++)

				{

					scriptElement = document.getElementById('page-cout_'+id_suffix+'_'+loop);

					if(scriptElement)

					{

						scriptCount = scriptElement.value;	

						//if(!scriptCount || 0 == parseInt(scriptCount))

						if(!parseInt(scriptCount))

						{

							alert('Enter pages for this script');	

							scriptElement.focus();

							return false;

						}

					}

				}

			}

		}

	}

	if(tlntCount == 0)

	{

		alert('Enter atleast one talent first');	

		document.getElementById('add_tlnt').focus();

		return false;

	}

	return true;

}

function delScript(idFlag)

{
	tlntFlag = idFlag.split("_")[0];
	if(tlntFlag==1){
		parentE = document.getElementById('demo-list');
	}else{
		parentE = document.getElementById('demo-list_'+tlntFlag);
	}
	scriptE = document.getElementById('file-'+idFlag);

	scriptName = document.getElementById('file-titleH_'+idFlag).value;
	parentE.removeChild(scriptE);

	calcTotalPage(tlntFlag);

	delScriptAjax(scriptName,tlntFlag);

}

function delScriptAjax(scriptName,index)

{

	//alert(scriptName);

	page = '<?php echo base_url();?>orders/removeScript';

	params = 'todo=<?=SCRIPT_DEL?>&script_name='+scriptName;

	respFunction = function(){ respDelScriptAjax(scriptName,index) } ;

	callAjaxPOST(page,params,respFunction);

}

					
</script>

<style type="text/css">

a.hover {s

	color: red;

}

 

.demo-list {

	padding: 0;

	list-style: none;

	margin: 0;

}

 

.demo-list .file-invalid {

	cursor: pointer;

	color: #514721;

	padding-left: 48px;

	line-height: 24px;

	background: url(../js/fancy-upload/error.png) no-repeat 24px 5px;

	margin-bottom: 1px;

}

.demo-list .file-invalid span {

	background-color: #fff6bf;

	padding: 1px;

}

 

.demo-list .file {

	line-height: 2em;

	/*padding-left: 22px;

	background: url(../js/fancy-upload/attach.png) no-repeat 1px 50%;*/

}

 

.demo-list .file span,

.demo-list .file a {

	padding: 0 4px;

}

 

.demo-list .file .file-size {

	color: #666;
	margin-left: 5px;
    font-weight: bold;

}

 

.demo-list .file .file-error {

	color: #8a1f11;

}

 

.demo-list .file .file-progress {

	width: 125px;

	height: 12px;

	vertical-align: middle;

	background-image: url(../js/fancy-upload/progress-bar/progress.gif);

}



#date_mod_display

{

	color:#F00;	

}
.upload{
	width:100%
}

</style>


