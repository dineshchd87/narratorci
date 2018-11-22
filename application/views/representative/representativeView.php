            <div class="col-sm-12 mt-4">
				<div class="view-order form-inline">
					<h2>CS Representative Management</h2> 
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
			
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4" id="export_buttons"></div>
				</div>
			</div>
			<div class="col-sm-12 mt-4">
                     <form class="form-inline float-right" id="searchForm" action="" method="get">
                        <div class="form-group mr-3">
                            <label class="mr-3"><strong>Manage : </strong> </label>         
                            <select data="<?php echo base_url();?>" name="searchField" id="searchField" class="form-control form-control-sm manage_page">
                                <option value="customers">Customers</option>
                                <option value="talents">Voice Talent</option>
                                <option value="representative" selected>Personnel</option>
                                <option value="managers">Managers</option>
                            </select>
                        </div>
                        <a href="<?php echo base_url();?>representative/add" class="btn btn-info"><i class="fas fa-plus-circle"></i> Add CS Representative</a>
                      
                        </form>
                <table id="csrTable" class="table display table-striped table-bordered" style="width:100%">
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
                            if(!empty($allCsr)){ 
                                foreach ($allCsr as $csr) {
                        ?>
                    
                    <tr id="csrRow_<?php echo $csr['csrm_id'];?>">
                        <td class="details-control" data="<?php echo $csr['csrm_id'];?>" id="<?php echo $csr['csrm_id'];?>"></td>
                         <td><?php echo $csr["user_fname"].' '.$csr["user_lname"];?></td>
                         <td><a href="mailto:<?php echo $csr["user_email"]; ?>" title="<?php echo $csr["user_email"]; ?>"><?php echo $csr["user_email"]; ?></a></td>
                         <td><?php echo $csr['csrm_rate'];?></td>
                         <td><?php echo $csr['user_phone'];?></td>
                         <td>
                             <select data="<?php echo $csr['user_id'];?>" class="form-control change_status_btn" id="customerStatus_<?php echo $csr['user_id'];?>">
                             <option value="Y" <?php if($csr['is_active'] == "Y"){ ?> selected="selected" <?php } ?>>Active</option>
                            <option value="N" <?php if($csr['is_active'] == "N"){?> selected="selected" <?php } ?>>Inactive</option>
                            </select>
                         <td> 
                          <a data-toggle="modal" data-target="<?php echo $csr['csrm_id'];?>" data="<?php echo $csr['user_id'];?>" href="javascript:void(0)" class="btn btn-dark btn-sm change_pass">
                               <i class="fas fa-edit"></i> Change Password
                            </a>
                            <a data-toggle="modal" data-target="<?php echo $csr['csrm_id'];?>" data="<?php echo $csr['user_id'];?>" href="javascript:void(0)" class="btn btn-danger btn-sm delete_btn">
                               <i class="fas fa-trash"></i> Delete
                            </a>
                            <a href="<?php echo base_url();?>customers/edit/<?php echo $csr['csrm_id'];?>" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i>
                                 Edit
                            </a>

                            <div id="record_<?php echo $csr['csrm_id'];?>" style="display: none;">
                               <div class="container">
                                    <div class="row">
                                        <div class="col-sm mycontent-left">
                                           <?php echo $csr["csrm_address1"];?>
                                           <div >
                                                <?php
                                                    echo $csr["csrm_city"].', ';
                                                    echo $csr["csrm_state"].' ';
                                                    echo $csr["csrm_zip"];
                                                ?>
                                            </div>
                                            <div ><?php echo $csr["country"];?></div>
                                        </div>
                                        <div class="col-sm mycontent-left">
                                            User name: <?php echo $csr["user_name"];?><br>
                                        </div>
                                    </div>
                                </div>
                            </div>


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
	var table = $('#csrTable').DataTable( {
        //"order": [[ 1, "desc" ]],
        "pagingType": "full_numbers",
        "searching":   true,
        // "processing": true,
       // "serverSide": true,
        //"ajax": "<?php //echo base_url();?>customers",
         /*"buttons": [  
         { 
            extend: 'excel', 
             text: '<i class="fas fa-cloud-download-alt"></i> Export Customers',
              init: function(api, node, config) {
                   $(node).addClass('btn-info')
                } 
         } ]*/
    });
  /*  table.buttons().container()
        .appendTo( '#export_buttons' );*/


     //$('#csrTable tbody').on('click', 'td.details-control', function () { 
        $('body').on('click', 'td.details-control', function() {
        var customerId = $(this).attr('data');
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
          // row.child( format(row.data()) ).show();
          row.child( $('#record_'+customerId).html()).show();
          tr.addClass('shown');
          tr.next().addClass('created-new-row');
          tr.next().attr('id','created_new_row_'+customerId); 
        }
    } );

     //===delete customer=======================
     $('body').on('click', '.delete_btn', function() {
     
        var selectedUser = $(this).attr('data');
        var selectedCsr = $(this).attr('data-target');		
        swal({
          title: "Are you sure?",
          text: "Really want to delete this record.",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false
        },
        function(){
            $.ajax({url: "<?php echo base_url();?>representative/deleteUser/"+selectedUser, 
                success: function(result){
                    $('#csrRow_'+selectedCsr).remove();
                    $('#created_new_row_'+selectedCsr).remove();
                    swal("Deleted!", "User deleted successfully.", "success");
                }
            });
        });
     });

	      //===delete customer=======================
     $('body').on('click', '.change_pass', function() {
     
        var selectedUser = $(this).attr('data');
        var selectedCsr = $(this).attr('data-target');
			
        swal({
          title: "Are you sure?",
          text: "Really want to change Password to this CSR.",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false
        },
        function(){
            $.ajax({url: "<?php echo base_url();?>representative/changePassword/"+selectedUser, 
                success: function(result){
                    
                    swal("Success!", "New Password sent to CSR.", "success");
                }
            });
        });
     });

    $('body').on('change', '.change_status_btn', function() {
        var selectedUser = $(this).attr('data');
        var status_type = $(this).val();
        $.ajax({url: "<?php echo base_url();?>representative/updateStatus/"+selectedUser, 
            type: "POST",
             data : { type : status_type },
            success: function(result){
                    swal({
                      title: "Sweet!",
                      text: "User status updated successfully.",
                      imageUrl: '<?php echo base_url();?>assets/images/thumbs-up.jpg'
                    });
            }
        });
     });
});
</script>  