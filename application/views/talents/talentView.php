            <div class="col-sm-12 mt-4">
				<div class="view-order form-inline">
					<h2>Talents Management</h2> 
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

			<div class="col-sm-12 mt-4">
                     <form class="form-inline float-right" id="searchForm" action="" method="get">
                        <div class="form-group mr-3">
                            <label class="mr-3"><strong>Manage : </strong> </label>         
                            <select data="<?php echo base_url();?>" name="searchField" id="searchField" class="form-control form-control-sm manage_page">
                                <option value="customers">Customers</option>
                                <option selected value="talents">Voice Talent</option>
                                <option value="representative">Personnel</option>
                                <option value="managers">Managers</option>
                            </select>
                        </div>
                        <a href="<?php echo base_url();?>talents/add" class="btn btn-info"><i class="fas fa-plus-circle"></i> Add Talent</a>
                        </form>
                <table id="talentTable" class="table display table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Rate</th>
                        <th>Phone</th>
                        <th>Status</th>
						<th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            if(!empty($allTalent)){ 
                                foreach ($allTalent as $tlnt) {
                        ?>
                    
                    <tr id="talentRow_<?php echo $tlnt['tlnt_id'];?>" dataid="<?php echo $tlnt['tlnt_id'];?>" >
                        <td class="details-control" data="<?php echo $tlnt['tlnt_id'];?>" id="<?php echo $tlnt['tlnt_id'];?>" data-cmt="<?php echo $tlnt['tlnt_cmnt'];?>"></td>
                         <td><?php echo stripslashes($tlnt['tlnt_fname'].' '.$tlnt['tlnt_lname']);?></td>
                         <td><a href="mailto:<?php echo $tlnt["tlnt_email"]; ?>" title="<?php echo $tlnt["tlnt_email"]; ?>"><?php echo $tlnt["tlnt_email"]; ?></a></td>
                         <td>
                             <?php echo $tlnt['tlnt_rate'];?>
                         </td> 
						 <td><?php echo $tlnt['tlnt_phone'];?></td>
						 
                         <td>
                             <select data="<?php echo $tlnt['tlnt_id'];?>" class="form-control change_status_btn" id="customerStatus_<?php echo $tlnt['tlnt'];?>">
                             <option value="Y" <?php if($tlnt['is_active'] == "Y"){ ?> selected="selected" <?php } ?>>Active</option>
                            <option value="N" <?php if($tlnt['is_active'] == "N"){?> selected="selected" <?php } ?>>Inactive</option>
                            </select>
                         </td> 
						 <td>
                            <a data-toggle="modal" data-target="#deleteCustomerModal" data="<?php echo $tlnt['tlnt_id'];?>" href="javascript:void(0)" class="btn btn-danger btn-sm delete_btn">
                               <i class="fas fa-trash"></i> Delete
                            </a>
                            <a href="<?php echo base_url();?>talents/edit/<?php echo $tlnt['tlnt_id'];?>" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i>
                                 Edit
                            </a>
                        </td>
                    </tr>

                     <?php
                       }
                   }else{
                    ?>
                    <tr>
                        <td colspan="6">
                             <div style="text-align: center;" class="alert alert-danger alert-dismissible">
                                <strong>Sorry!</strong> No records found.
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
				
			
			</div>	

<script>
$(document).ready(function() {	
	var table = $('#talentTable').DataTable( {
        //"order": [[ 1, "desc" ]],
        "pagingType": "full_numbers",
        "searching":   true,
        // "processing": true,
       // "serverSide": true,
        //"ajax": "<?php //echo base_url();?>customers",
         "buttons": [  
         { 
            extend: 'excel', 
             text: '<i class="fas fa-cloud-download-alt"></i> Export Customers',
              init: function(api, node, config) {
                   $(node).addClass('btn-info')
                } 
         } ]
    });
    table.buttons().container()
        .appendTo( '#export_buttons' );


     //$('#customerTable tbody').on('click', 'td.details-control', function () { 
        $('body').on('click', 'td.details-control', function() {
        var tlntId = $(this).attr('data');
		 var cmt = $(this).attr('data-cmt');
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
           row.child( format(tlntId,cmt) ).show();
            tr.addClass('shown');
            
        }
    } );

     //===delete customer=======================
     $('body').on('click', '.delete_btn', function() {
        var selectedTalent = $(this).attr('data');
        swal({
          title: "Are you sure?",
          text: "Really want to delete this Talent.",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false
        },
        function(){
            $.ajax({url: "<?php echo base_url();?>talents/deleteTalent/"+selectedTalent, 
                success: function(result){
                    $('#talentRow_'+selectedTalent).remove();
                    $('#created_new_row_'+selectedTalent).remove();
                    swal("Deleted!", "Talent deleted successfully.", "success");
                }
            });
        });
     });


    $('body').on('change', '.change_status_btn', function() {
        var selectedTalent = $(this).attr('data');
        var status_type = $(this).val();		
        $.ajax({url: "<?php echo base_url();?>talents/updatestatus/"+selectedTalent, 
            type: "POST",
            data : { type : status_type },
            success: function(result){
                    swal({
                      title: "Sweet!",
                      text: "Talent status updated successfully.",
                      imageUrl: '<?php echo base_url();?>assets/images/thumbs-up.jpg'
                    });
            }
        });
     });
	 
	  $('body').on('blur', '.note', function() {
			var selectedTalent = $(this).attr('data-id');
			$.ajax({url: "<?php echo base_url();?>talents/updatNote/"+selectedTalent, 
            type: "POST",
            data : { note : $(this).val() },
            success: function(result){
                    swal({
                      title: "Sweet!",
                      text: "Note updated successfully.",
                      imageUrl: '<?php echo base_url();?>assets/images/thumbs-up.jpg'
                    });
            }
        });
	});
		function format ( d ,cmmt ) {
			// `d` is the original data object for the row
			return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
						'<div class="form-group">'+
							'<label for="comment">Note:</label>'+
							'<textarea class="form-control note" rows="5" data-id="'+ d +'">'+
								cmmt
							'</textarea>'+
						'</div>'+
					'</table>';
		}
	 

});
</script>  