            <div class="col-sm-12 mt-4">
				<div class="view-order form-inline">
					<h2>Customers Management</h2> 
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
                            <select name="searchField" id="searchField" class="form-control form-control-sm">
                                <option value="cust">Customers</option>
                                <option value="comp">Voice Talent</option>
                                <option value="tlnt">Personnel</option>
                                <option value="csr">Managers</option>
                            </select>
                        </div>
                        <a href="<?php echo base_url();?>customers/add" class="btn btn-info"><i class="fas fa-plus-circle"></i> Add Customer</a>
                        </form>
                <table id="customerTable" class="table display table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            if(!empty($allCustomers)){ 
                                foreach ($allCustomers as $customer) {
                        ?>
                    
                    <tr id="customerRow_<?php echo $customer['cust_id'];?>">
                        <td class="details-control" data="<?php echo $customer['cust_id'];?>" id="<?php echo $customer['cust_id'];?>"></td>
                         <td><?php echo stripslashes($customer['cust_name']);?></td>
                         <td><a href="mailto:<?php echo $customer["cust_email"]; ?>" title="<?php echo $customer["cust_email"]; ?>"><?php echo $customer["cust_email"]; ?></a></td>
                         <td><?php echo $customer['cust_phone'];?></td>
                         <td>
                             <select data="<?php echo $customer['cust_id'];?>" class="form-control change_status_btn" id="customerStatus_<?php echo $customer['cust_id'];?>">
                             <option value="Y" <?php if($customer['is_active'] == "Y"){ ?> selected="selected" <?php } ?>>Active</option>
                            <option value="N" <?php if($customer['is_active'] == "N"){?> selected="selected" <?php } ?>>Inactive</option>
                            </select>
                         <td> 
                            <a data-toggle="modal" data-target="#deleteCustomerModal" data="<?php echo $customer['cust_id'];?>" href="javascript:void(0)" class="btn btn-danger btn-sm delete_btn">
                               <i class="fas fa-trash"></i> Delete
                            </a>
                            <a href="<?php echo base_url();?>customers/edit/<?php echo $customer['cust_id'];?>" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i>
                                 Edit
                            </a>

                            <div id="record_<?php echo $customer['cust_id'];?>" style="display: none;">
                               <div class="container">
                                    <div class="row">
                                        <div class="col-sm mycontent-left">
                                            <?php 
                                                echo $customer["cust_title"].'<br/>';
                                                echo $customer["cust_comp"];
                                                ?>
                                        </div>
                                        <div class="col-sm mycontent-left">
                                             <div style="line-height:16px;">
                                                <?php echo $customer["cust_address1"];?>
                                                    
                                                </div>
                                            <div style="line-height:16px;">
                                                <?php
                                                    echo $customer["cust_city"].', ';
                                                    echo $customer["cust_state"].' ';
                                                    echo $customer["cust_zip"];
                                                ?>
                                            </div>
                                            <div style="line-height:16px;"><?php echo $customer["country"];?></div>
                                        </div>
                                        <div class="col-sm" id="revenuVal_<?php echo $customer['cust_id'];?>"></div>
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
	var table = $('#customerTable').DataTable( {
        //"order": [[ 1, "desc" ]],
        "pagingType": "full_numbers",
        "searching":   false,
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


     $('#customerTable tbody').on('click', 'td.details-control', function () { 
        var customerId = $(this).attr('data');
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
           // row.child( format(row.data()) ).show();
             swal({
                title: "Please wait!",
                text: "Loading...",
                type: "info",
                showCancelButton: false,
                showConfirmButton: false
             });
             $.ajax({url: "<?php echo base_url();?>customers/get_revenue_details/"+customerId, 
                success: function(result){
                    var obj = jQuery.parseJSON(result);
                    swal.close();
                    var totalVal = parseInt(obj[0]['totalval']).toFixed(2);
                    totalVal = totalVal.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    $('#revenuVal_'+customerId).html('$'+totalVal);
                    row.child( $('#record_'+customerId).html()).show();
                    tr.addClass('shown');
                    tr.next().addClass('created-new-row');
                }
            }); 
        }
    } );

     //===delete customer=======================
     $('.delete_btn').click(function(){
        var selectedCustomer = $(this).attr('data');
        $('#selectedCustomer').val();
        swal({
          title: "Are you sure?",
          text: "You want to delete this customer.",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false
        },
        function(){
            $.ajax({url: "<?php echo base_url();?>customers/deleteCustomer/"+selectedCustomer, 
                success: function(result){
                    $('#customerRow_'+selectedCustomer).remove();
                    swal("Deleted!", "Customer deleted successfully.", "success");
                }
            });
        });
     });


      $('.change_status_btn').change(function(){
        var selectedCustomer = $(this).attr('data');
        var status_type = $(this).val();
        $.ajax({url: "<?php echo base_url();?>customers/updateStatus/"+selectedCustomer, 
            type: "POST",
             data : { type : status_type },
            success: function(result){
                    swal({
                      title: "Sweet!",
                      text: "Customer status updated successfully.",
                      imageUrl: '<?php echo base_url();?>assets/images/thumbs-up.jpg'
                    });
            }
        });
     });
});
</script>  