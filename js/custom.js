// JavaScript Document
jQuery(function ($) {
	
	"use strict";
	
	var base_url = location.protocol + '//' + location.host + location.pathname ;
	base_url = base_url.substring(0, base_url.lastIndexOf("/") + 1);
	
	$(document).on("scroll", function(){
			if
		  ($(document).scrollTop() > 86){
			  $("#banner").addClass("shrink");
			}
			else
			{
				$("#banner").removeClass("shrink");
			}
	});
	$(document).on("click","#logreg-forms #btn-signup ", function() {
		$('#logreg-forms .form-signup').toggle();
		$('#logreg-forms .form-signin').toggle();
	});
 	$(document).on("click","#logreg-forms #cancel_signup ", function() {
		$('#logreg-forms .form-signup').toggle();
		$('#logreg-forms .form-signin').toggle();
	});
  	$(document).on("click","#logreg-forms #forgot_pswd", function() {
		$('#logreg-forms .form-signin').toggle(); 
   		$('#logreg-forms .form-reset').toggle();											 
	});
  	$(document).on("click","#logreg-forms #cancel_reset", function() {
		$('#logreg-forms .form-signin').toggle(); 
   		$('#logreg-forms .form-reset').toggle();											 
	});
  	$(document).on("click","#hide", function() {
		$(".errorMessage").hide();
	});
	var manageAdminTable = $('#manageAdminTable').DataTable({
		'ajax': base_url+'fetchAdmin.php',
		'order': []
	});
	var manageManagerTable = $('#manageManagerTable').DataTable({
		'ajax': base_url+'fetchManager.php',
		'order': []
	});
	var manageCategoryTable = $('#manageCategoryTable').DataTable({
		'ajax': base_url+'fetchCategory.php',
		'order': []
	});

    var manageCategoryTable = $('#manageCategory2Table').DataTable({
		'ajax': base_url+'fetchCategory2.php',
		'order': []
	});
    
    
    var manageLogTable = $('#manageLogTable').DataTable({
		'ajax': base_url+'fetchCategory.php',
		'order': []
	});
    
	var manageBrandTable = $('#manageBrandTable').DataTable({
		'ajax': base_url+'fetchBrand.php',
		'order': []
	});
	var manageTaxTable = $('#manageTaxTable').DataTable({
		'ajax': base_url+'fetchTax.php',
		'order': []
	});
    var manageTaxTable = $('#manageMarkupTable').DataTable({
		'ajax': base_url+'fetchMarkup.php',
		'order': []
	});
	var manageProductTable = $('#manageProductTable').DataTable({
		'ajax': base_url+'fetchProduct.php',
		'order': []
	});
    
    var manageProductTable = $('#manageProductTable2').DataTable({
		'ajax': base_url+'fetchProduct2.php',
		'order': []
	});
    
    
    
    	var manageServiceTable = $('#manageServiceTable').DataTable({
		'ajax': base_url+'fetchService.php',
		'order': []
	});
	var manageCustomerTable = $('#manageCustomerTable').DataTable({
		'ajax': base_url+'fetchCustomer.php',
		'order': []
	});
    
    var manageCustomerTable = $('#manageEmployeeTable').DataTable({
		'ajax': base_url+'fetchEmployee.php',
		'order': []
	});
    
	var manageOrderTable = $('#manageOrderTable').DataTable({
		'ajax': base_url+'fetchOrder.php',
		'order': []
	});
    
    
    
    	var manageOrderTable = $('#manageOrderTable2').DataTable({
		'ajax': base_url+'fetchOrder2.php',
		'order': []
	});
    
    
    
    
   // var productLogTable = $('#productLogTable').DataTable({
		//'ajax': base_url+'fetchprodLog.php',
		//'order': []
	//});
    
    
	var manageCurrentDayOrderTable = $('#manageCurrentDayOrderTable').DataTable({
		'ajax': base_url+'fetchCurrentDayTotalOrder.php',
		'order': []
	});
	var manageCurrentMonthOrderTable = $('#manageCurrentMonthOrderTable').DataTable({
		'ajax': base_url+'fetchCurrentMonthTotalOrder.php',
		'order': []
	});
	var manageTotalOrderTable = $('#manageTotalOrderTable').DataTable({
		'ajax': base_url+'fetchTotalOrder.php',
		'order': []
	});
	var manageUserOrderTable = $('#manageUserOrderTable').DataTable({
		'ajax': base_url+'fetchUserTotalOrder.php',
		'order': []
	});
	
	$(document).on('click', '.changeAdminStatus', function(){
			var adminId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeAdminStatus";
			if(confirm("Are you sure you want to change Admin status?"))
			{
				$.ajax({
					url: base_url+"change_admin_status.php",
					method:"POST",
					data:{adminId:adminId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageAdminTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	$(document).on('click', '.delAdminStatus', function(){
			var adminId = $(this).attr("id");
			var btn_action = "delAdminStatus";
			if(confirm("Are you sure you want to Delete this Admin Permanently? It cannot be undone."))
			{
				$.ajax({
					url: base_url+"delete_admin.php",
					method:"POST",
					data:{adminId:adminId, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageAdminTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	$(document).on('click', '.changeManagerStatus', function(){
			var managerId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeManagerStatus";
			if(confirm("Are you sure you want to change Manager status?"))
			{
				$.ajax({
					url: base_url+"change_manager_status.php",
					method:"POST",
					data:{managerId:managerId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageManagerTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	$(document).on('click', '.delManagerStatus', function(){
			var managerId = $(this).attr("id");
			var btn_action = "delManagerStatus";
			if(confirm("Are you sure you want to Delete this Manager Permanently? It cannot be undone."))
			{
				$.ajax({
					url: base_url+"delete_manager.php",
					method:"POST",
					data:{managerId:managerId, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageManagerTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	$(document).on('click', '.changeCategoryStatus', function(){
			var categoryId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeCategoryStatus";
			if(confirm("Are you sure you want to change Category status?"))
			{
				$.ajax({
					url: base_url+"change_category_status.php",
					method:"POST",
					data:{categoryId:categoryId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageCategoryTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		 
		});
    
    
    	$(document).on('click', '.changeCategory2Status', function(){
			var categoryId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeCategory2Status";
			if(confirm("Are you sure you want to change Category status?"))
			{
				$.ajax({
					url: base_url+"change_category2_status.php",
					method:"POST",
					data:{categoryId:categoryId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageCategoryTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		 
		});
    
    
    
    
	$(document).on('click', '.changeBrandStatus', function(){
			var brandId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeBrandStatus";
			if(confirm("Are you sure you want to change Brand status?"))
			{
				$.ajax({
					url: base_url+"change_brand_status.php",
					method:"POST",
					data:{brandId:brandId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageBrandTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	$(document).on('click', '.changeTaxStatus', function(){
			var taxId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeTaxStatus";
			if(confirm("Are you sure you want to change Tax status?"))
			{
				$.ajax({
					url: base_url+"change_tax_status.php",
					method:"POST",
					data:{taxId:taxId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageTaxTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
    
    
    
    	$(document).on('click', '.changeMarkupStatus', function(){
			var markupId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeMarkupStatus";
			if(confirm("Are you sure you want to change Markup status?"))
			{
				$.ajax({
					url: base_url+"change_markup_status.php",
					method:"POST",
					data:{markupId:markupId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageMarckupTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
    
    
	$(document).on('click', '.changeProductStatus', function(){
			var productId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeProductStatus";
			if(confirm("Are you sure you want to change Product status?"))
			{
				$.ajax({
					url: base_url+"change_product_status.php",
					method:"POST",
					data:{productId:productId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageProductTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	$(document).on('click', '.changeCustomerStatus', function(){
			var customerId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeCustomerStatus";
			if(confirm("Are you sure you want to change Customer status?"))
			{
				$.ajax({
					url: base_url+"change_customer_status.php",
					method:"POST",
					data:{customerId:customerId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageCustomerTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	$(document).on('click', '#add_admin', function(){
		$('#adminModal').modal('show');
		$('#admin_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add New Admin");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
	$(document).on('submit','#admin_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"admin_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#admin_form')[0].reset();
				$('#adminModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageAdminTable.ajax.reload();
			}
		})
	});
	$(document).on('click', '#add_manager', function(){
		$('#managerModal').modal('show');
		$('#manager_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add New Manager");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
	$(document).on('submit','#manager_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"manager_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#manager_form')[0].reset();
				$('#managerModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageManagerTable.ajax.reload();
			}
		})
	});
	$(document).on('click', '#add_category', function(){
		$('#categoryModal').modal('show');
		$('#category_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add New Category");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
	$(document).on('submit','#category_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_category_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#category_form')[0].reset();
				$('#categoryModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageCategoryTable.ajax.reload();
			}
		})
	});
    
    
    
    	$(document).on('submit','#category2_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_category2_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#category_form')[0].reset();
				$('#categoryModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageCategoryTable.ajax.reload();
			}
		})
	});
    
    
	$(document).on('click', '.updateCategory', function(){
		var category_id = $(this).attr("id");
		var btn_action = 'fetch_category';
		$.ajax({
			url: base_url+"update_category_action.php",
			method:"POST",
			data:{category_id:category_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#categoryModal').modal('show');
				$('#category_name').val(data.category_name);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Category");
				$('#category_id').val(category_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
			}
		})
	});
	$(document).on('click', '#add_brand', function(){
		$('#brandModal').modal('show');
		$('#brand_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add New Brand");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
	$(document).on('submit','#brand_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_brand_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#brand_form')[0].reset();
				$('#brandModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageBrandTable.ajax.reload();
			}
		})
	});
	$(document).on('click', '.updateBrand', function(){
		var brand_id = $(this).attr("id");
		var btn_action = 'fetch_brand';
		$.ajax({
			url: base_url+"update_brand_action.php",
			method:"POST",
			data:{brand_id:brand_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#brandModal').modal('show');
				$('#category_id').val(data.category_id);
				$('#brand_name').val(data.brand_name);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Brand");
				$('#brand_id').val(brand_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
			}
		})
	});
	
    
    
    
    
    
    
    $(document).on('click', '#add_tax', function(){
		$('#taxModal').modal('show');
		$('#tax_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add New Tax Slab");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
	$(document).on('submit','#tax_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_tax_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#tax_form')[0].reset();
				$('#taxModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageTaxTable.ajax.reload();
			}
		})
	});
	$(document).on('click', '.updateTax', function(){ 
		var tax_id = $(this).attr("id");
		var btn_action = 'fetch_tax';
		$.ajax({
			url: base_url+"update_tax_action.php",
			method:"POST",
			data:{tax_id:tax_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#taxModal').modal('show');
				$('#tax_rate').val(data.tax_slab_rate);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Tax Slab");
				$('#tax_id').val(tax_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
			}
		})
	});

    
    
    
    
    $(document).on('click', '#add_markup', function(){
		$('#markupModal').modal('show');
		$('#markup_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add New Mark Up");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
	$(document).on('submit','#markup_form', function(event){
        
        //alert("saving!!!");
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_markup_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#markup_form')[0].reset();
				$('#markupModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageMarkupTable.ajax.reload();
			}
		})
	});
	$(document).on('click', '.updateMarkup', function(){ 
		var markup_id = $(this).attr("id");
		var btn_action = 'fetch_markup';
		$.ajax({
			url: base_url+"update_markup_action.php",
			method:"POST",
			data:{markup_id:markup_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#markupModal').modal('show');
				$('#markup_rate').val(data.markup_slab_rate);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Tax Slab");
				$('#markup_id').val(markup_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
			}
		})
	});

    
    
    
    $(document).on('click', '#add_product', function(){
		$('#productModal').modal('show');
		$('#product_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add New Product");
		$('#product_quantity').val('');
		$('.pr').hide();
		$('#product_quantity').prop('readonly',false);
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
	$(document).on('submit','#product_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_product_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#product_form')[0].reset();
				$('#productModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageProductTable.ajax.reload();
			}
		})
	});
	$(document).on('change','#category_id', function(){
        var category_id = $('#category_id').val();
        var btn_action = 'load_brand';
        $.ajax({
            url: base_url+"add_product_action.php",
            method:"POST",
            data:{category_id:category_id, btn_action:btn_action},
            success:function(data)
            {
                $('#brand_id').html(data);
            }
        });
    });
	$(document).on('keyup','#product_sku', function(){
        var product_sku = $('#product_sku').val();
        var btn_action = 'check_sku';
        $.ajax({
            url: base_url+"add_product_action.php",
            method:"POST",
            data:{product_sku:product_sku, btn_action:btn_action},
            success:function(data)
            {
                $('#check_product_sku').html(data);
            }
        });
    });
	$(document).on('click', '.updateProduct', function(){
        var product_id = $(this).attr("id");
        var btn_action = 'fetch_single_product';
        $.ajax({
            url: base_url+"add_product_action.php",
            method:"POST",
            data:{product_id:product_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#productModal').modal('show');
				$('.pr').show();
				$('#product_quantity').prop('readonly',true);
                $('#category_id').val(data.category_id);
                $('#brand_id').html(data.brand_select_box);
                $('#brand_id').val(data.brand_id);
                $('#product_name').val(data.product_name);
                $('#product_sku').val(data.product_sku);
                $('#product_qt').html(data.product_input_type);
				$('#product_quantity').val(data.product_quantity);
                $('#product_unit').val(data.product_unit);
                $('#product_sp').val(data.product_selling_price);
                $('#tax_rate').val(data.product_tax_rate);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Product");
                $('#product_id').val(product_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });
    
    
    
    
    
    
    
    

    
    
    
    $(document).on('click', '#add_service', function(){
		$('#serviceModal').modal('show');
		$('#service_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add New Service");
		$('#service_quantity').val('');
		$('.pr').hide();
		$('#service_quantity').prop('readonly',false);
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
	$(document).on('submit','#service_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_service_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#service_form')[0].reset();
				$('#serviceModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageServiceTable.ajax.reload();
			}
		})
	});
	$(document).on('change','#category_id', function(){
        var category_id = $('#category_id').val();
        var btn_action = 'load_brand';
        $.ajax({
            url: base_url+"add_service_action.php",
            method:"POST",
            data:{category_id:category_id, btn_action:btn_action},
            success:function(data)
            {
                $('#brand_id').html(data);
            }
        });
    });
	$(document).on('keyup','#service_sku', function(){
        var service_sku = $('#service_sku').val();
        var btn_action = 'check_sku';
        $.ajax({
            url: base_url+"add_service_action.php",
            method:"POST",
            data:{service_sku:service_sku, btn_action:btn_action},
            success:function(data)
            {
                $('#check_service_sku').html(data);
            }
        });
    });
	$(document).on('click', '.updateService', function(){
        var service_id = $(this).attr("id");
        var btn_action = 'fetch_single_service';
        $.ajax({
            url: base_url+"add_service_action.php",
            method:"POST",
            data:{service_id:service_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#serviceModal').modal('show');
				$('.pr').show();
				$('#service_quantity').prop('readonly',true);
                $('#category_id').val(data.category_id);
                $('#brand_id').html(data.brand_select_box);
                $('#brand_id').val(data.brand_id);
                $('#service_name').val(data.service_name);
                $('#service_sku').val(data.service_sku);
                $('#service_qt').html(data.service_input_type);
				$('#service_quantity').val(data.service_quantity);
                $('#service_unit').val(data.service_unit);
                $('#service_sp').val(data.service_selling_price);
                $('#tax_rate').val(data.service_tax_rate);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Service");
                $('#service_id').val(service_id);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });
    
    
    
    
    
    
	$(document).on('submit','#currency_form', function(event){
		event.preventDefault();
		$('#action_currency').attr('disabled','disabled');
		$('#action_currency').val('Update');
		$('#btn_action_currency').val('Add');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_currency.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#currency_form')[0].reset();
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action_currency').attr('disabled', false);
			}
		})
	});
	$(document).on('click', '#add_customer', function(){
		$('#customerModal').modal('show');
		$('#customer_form')[0].reset();
		$('#modal-title').html("<i class='fa fa-plus'></i> Add New Customer");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
	$(document).on('submit','#customer_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_customer_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#customer_form')[0].reset();
				$('#customerModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageCustomerTable.ajax.reload();
			}
		})
	});
	
    
    
    $(document).on('click', '.updateCustomer', function(){
		var customer_id = $(this).attr("id");
		var btn_action = 'fetch_customer';
		$.ajax({
			url: base_url+"add_customer_action.php",
			method:"POST",
			data:{customer_id:customer_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#customerModal').modal('show');
				$('#customer_name').val(data.customer_name);
				$('#customer_email').val(data.customer_email);
				$('#customer_mobile').val(data.customer_mobile);
				$('#customer_tax').val(data.customer_tax);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Customer");
				$('#customer_id').val(customer_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
			}
		})
	});
    
    

    $(document).on('click', '#add_employee', function(){
		$('#employeeModal').modal('show');
		$('#employee_form')[0].reset();
		$('#modal-title').html("<i class='fa fa-plus'></i> Add New Employee");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
    
    
     $(document).on('click', '#add_denomination', function(){
		$('#denominationModal').modal('show');
		$('#denomination_form')[0].reset();
		$('#modal-title').html("<i class='fa fa-plus'></i> Add New Denomination");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
    
    
    
        $(document).on('click', '#add_expenses', function(){
		$('#expensesModal').modal('show');
		$('#expenses_form')[0].reset();
		$('#modal-title').html("<i class='fa fa-plus'></i> Add New Expenses");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});
    
    
    
    
    $(document).on('submit','#employee_form', function(event){
        
        //alert("debug1");
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_employee_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#employee_form')[0].reset();
				$('#employeeModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action').attr('disabled', false);
				manageEmployeeTable.ajax.reload();
			}
		})
	});
	$(document).on('click', '.updateEmployee', function(){
        //alert("debug2");
        
		var employee_id = $(this).attr("id");
		var btn_action = 'fetch_employee';
		$.ajax({
			url: base_url+"add_employee_action.php",
			method:"POST",
			data:{employee_id:employee_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#employeeModal').modal('show');
				$('#employee_name').val(data.employee_name);
				$('#employee_email').val(data.employee_email);
				$('#employee_mobile').val(data.employee_mobile);
				$('#employee_tax').val(data.employee_tax);
                $('#employee_sss').val(data.employee_sss);
                $('#employee_pagibig').val(data.employee_pagibig);
                $('#employee_idnum').val(data.employee_idnum);
                $('#employee_salary').val(data.employee_salary);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Employee");
				$('#employee_id').val(employee_id);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
			}
		})
	});
    
    
    
	$(document).on('submit','#order_form', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"add_order_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#order_form')[0].reset();
				$('#orderModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
				$('#action_pro').attr('disabled', false);
				manageCustomerTable.ajax.reload();
			}
		})
	});
	var myProductDetail;
	$.ajax({
		url: base_url+"pro_detail.php",
		method:"POST",
		dataType: "html",
		success:function(data)
			{
				myProductDetail = data ;
			}
	});
    
    
   var myServiceDetail;
	$.ajax({
		url: base_url+"pro_detail2.php",
		method:"POST",
		dataType: "html",
		success:function(data)
			{
				myServiceDetail = data ;
			}
	});
	
    
    $(document).on('click', '.header_order2', function(){												
		
				$('#headerorderModal2').modal('show');
				$('#headerorder_form2')[0].reset();
				$('.modal-title2').html("<i class='fa fa-pencil-square-o'></i> Add Service");
				$('#action_pro2').attr('disabled','disabled');
				$('#discount2').prop('readonly',true);
				$('.span_product_details').html('');
				$('.user_selectpicker').selectpicker('refresh');
				add_product_row2();
	});
    
    
    $(document).on('click', '.header_order', function(){												
		
				$('#headerorderModal').modal('show');
				$('#headerorder_form')[0].reset();
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Add Order");
				$('#action_pro').attr('disabled','disabled');
				$('#discount').prop('readonly',true);
				$('.span_product_details').html('');
				$('.user_selectpicker').selectpicker('refresh');
				add_product_row();
	});
    
	
	$(document).on('click', '.editOrder', function(){
		var orderId = $(this).attr("id");
		var btn_action_pro = 'fetch_order';
		$.ajax({
			url: base_url+"add_order_action.php",
			method:"POST",
			data:{orderId:orderId, btn_action_pro:btn_action_pro},
			dataType:"json",
			success:function(data)
			{	
				
				$('#editorderModal').modal('show');
				$('#editordercustomer_name').val(data.order_customername);
				$('#editordercustomer_email').val(data.order_customer_email);
				$('#editordercustomer_mobile').val(data.order_customer_mobile);
				$('#editordercustomer_tax').val(data.order_customer_tax_no);
				$('#editdiscount').val(data.order_discount);
				$('#edittotalAftertax').val(data.order_total);
				$('#editpaid').val(data.order_paid_amount);
				$('#editdue').val(data.order_due_amount);
				$('#order_id').val(orderId);
				$('.order_date').val(data.order_date);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Order");
				$('.action_pro').attr('disabled',false);
				$('.btn_action_pro').val('EditOrder');
				$('.span_editproduct_details').html(data.product_details);
				$('.selectpicker').selectpicker('refresh');
				
			}
		})
	});
	
	$(document).on('click', '.createOrder', function(){												
		var customer_id = $(this).attr("id");
		var btn_action_pro = 'fetch_customer';
		$('#singleorder_form')[0].reset();
		$.ajax({
			url: base_url+"add_singleorder_action.php",
			method:"POST",
			data:{customer_id:customer_id, btn_action_pro:btn_action_pro},
			dataType:"json",
			success:function(data)
			{	
				
				$('#singleorderModal').modal('show');
				$('#singleordercustomer_name').val(data.customer_name);
				$('#singleordercustomer_email').val(data.customer_email);
				$('#singleordercustomer_mobile').val(data.customer_mobile);
				$('#singleordercustomer_tax').val(data.customer_tax);
				$('#modal-title').html("<i class='fa fa-pencil-square-o'></i> Add Order");
				$('#singleordercustomer_id').val(customer_id);
				$('#action_prosingle').attr('disabled','disabled');
				$('#singlediscount').prop('readonly',true);
				$('.span_singleproduct_details').html('');
				add_singleproduct_row();
				
			}
		})
	});
	

    
    
    	function add_product_row2(count = '')
		{	
			var html2 = '';
			if(count == 0)
			{
				html2 += '<button type="button" name="add_more" id="add_more2" class="btn btn-success btn-xs add_more2">+Add Service</button>';
				$('#action_pros2').attr('disabled','disabled');
				
			}
			else
			{	
				
				html2 += '<span id="rows'+count+'"><div class="row">';
				html2 += '<div class="col-md-6"><div class="form-group"><label>Service</label>';
				html2 += '<select name="service_id[]" id="service_id'+count+'" class="form-control selectpicker service_id" data-live-search="true" required><option data-price="0" value="">Select Service</option>';
				html2 += myServiceDetail;
				html2 += '</select>';
				html2 += '</div></div>';
				html2 += '<div class="col-md-2"><div class="form-group"><label>Quantity</label>';
				html2 += '<input type="text" name="quantitys[]" id="quantitys'+count+'" class="form-control quantitys" required "  />';
				html2 += '</div></div>';
				html2 += '<div class="col-md-3"><div class="form-group"><label>Price</label>';
				html2 += '<span class="myservice_price'+count+'"><input type="text" name="service_price[]" id="service_price'+count+'" class="form-control service_price" readonly="readonly"/></span>';
				html2 += '</div></div>';
				html2 += '<div class="col-md-1"><div class="form-group"><label>Remove</label>';
				html2 += '<button type="button" name="remove" id="s'+count+'" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i></button>';
				html2 += '</div></div>';
				$('#action_pros2').attr('disabled',false);
				$('#action_pros2').val('Add Order');
				$('#btn_action_pros2').val('AddOrder');
			}
			html2 += '</div></span>';
			$('.span_service_details').append(html2);
			$('.selectpicker').selectpicker('refresh');
		}
    
    
    
    function add_product_row(count = '')
		{	
			var html = '';
			if(count == 0)
			{
				html += '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs add_more">+Add Product</button>';
				$('#action_pros').attr('disabled','disabled');
				
			}
			else
			{	
				
				html += '<span id="row'+count+'"><div class="row">';
				html += '<div class="col-md-6"><div class="form-group"><label>Product</label>';
				html += '<select name="product_id[]" id="product_id'+count+'" class="form-control selectpicker product_id" data-live-search="true" required><option data-price="0" value="">Select Product</option>';
				html += myProductDetail;
				html += '</select>';
				html += '</div></div>';
				html += '<div class="col-md-2"><div class="form-group"><label>Quantity</label>';
				html += '<input type="text" name="quantity[]" id="quantity'+count+'" class="form-control quantity" required "  />';
				html += '</div></div>';
				html += '<div class="col-md-3"><div class="form-group"><label>Price</label>';
				html += '<span class="myproduct_price'+count+'"><input type="text" name="product_price[]" id="product_price'+count+'" class="form-control product_price" readonly="readonly"/></span>';
				html += '</div></div>';
				html += '<div class="col-md-1"><div class="form-group"><label>Remove</label>';
				html += '<button type="button" name="remove" id="'+count+'" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i></button>';
				html += '</div></div>';
				$('#action_pros').attr('disabled',false);
				$('#action_pros').val('Add Order');
				$('#btn_action_pros').val('AddOrder');
			}
			html += '</div></span>';
			$('.span_product_details').append(html);
			$('.selectpicker').selectpicker('refresh');
		}
    
    
    
    
    
		var count = 0;
		$(document).on('click', '.add_more', function(){
			count++ ;
			add_product_row(count);
			if( ($('#discount').val() == '') && ($('#discount').val() < 1) ){
				$('#discount').val('0');
			}
			$('#discount').prop('readonly',false);
		});
    
    
    	var count = 0;
		$(document).on('click', '.add_more2', function(){
			count++ ;
			add_product_row2(count);
			if( ($('#discount2').val() == '') && ($('#discount2').val() < 1) ){
				$('#discount2').val('0');
			}
			$('#discount2').prop('readonly',false);
		});
    
    
		
		function add_editproduct_row(editcount = '')
		{	
			var edithtml = '';
			edithtml += '<span id="row'+editcount+'"><div class="row">';
			edithtml += '<div class="col-md-6"><div class="form-group"><label>Product</label>';
			edithtml += '<select name="product_id[]" id="product_id'+editcount+'" class="form-control selectpicker editproduct_id" data-live-search="true" required><option data-price="0" value="">Select Product</option>';
			edithtml += myProductDetail;
			edithtml += '</select>';
			edithtml += '</div></div>';
			edithtml += '<div class="col-md-2"><div class="form-group"><label>Quantity</label>';
			edithtml += '<input type="text" name="quantity[]" id="quantity'+editcount+'" class="form-control editquantity" required "  />';
			edithtml += '</div></div>';
			edithtml += '<div class="col-md-3"><div class="form-group"><label>Price</label>';
			edithtml += '<span class="myproduct_price'+editcount+'"><input type="text" name="product_price[]" id="product_price'+editcount+'" class="form-control editproduct_price" readonly="readonly"/></span>';
			edithtml += '</div></div>';
			edithtml += '<div class="col-md-1"><div class="form-group"><label>Remove</label>';
			edithtml += '<button type="button" name="remove" id="'+editcount+'" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i></button>';
			edithtml += '</div></div>';
			$('.action_pro').attr('disabled',false);
			$('.action_pro').val('Edit Order');
			$('.btn_action_pro').val('EditOrder');
			edithtml += '</div></span>';
			$('.span_editproduct_details').append(edithtml);
			$('.selectpicker').selectpicker('refresh');
		}
		var editcount = 1;
		$(document).on('click', '#add_editmore', function(){
			editcount++ ;
			add_editproduct_row(editcount);
			if( ($('#editdiscount').val() == '') && ($('#editdiscount').val() < 1) ){
				$('#editdiscount').val('0');
			}
		});
		
		function add_singleproduct_row(singlecount = '')
		{	
			var orderhtml = '';
			if(singlecount == 0)
			{
				orderhtml += '<button type="button" name="add_more" id="add_moresingle" class="btn btn-success btn-xs add_moresingle">+Add Product</button>';
				$('#action_prosingle').attr('disabled','disabled');
				
			}
			else
			{	
				
				orderhtml += '<span id="row'+singlecount+'"><div class="row">';
				orderhtml += '<div class="col-md-6"><div class="form-group"><label>Product</label>';
				orderhtml += '<select name="product_id[]" id="product_id'+singlecount+'" class="form-control selectpicker singleproduct_id" data-live-search="true" required><option data-price="0" value="">Select Product</option>';
				orderhtml += myProductDetail;
				orderhtml += '</select>';
				orderhtml += '</div></div>';
				orderhtml += '<div class="col-md-2"><div class="form-group"><label>Quantity</label>';
				orderhtml += '<input type="text" name="quantity[]" id="quantity'+singlecount+'" class="form-control singlequantity" required "  />';
				orderhtml += '</div></div>';
				orderhtml += '<div class="col-md-3"><div class="form-group"><label>Price</label>';
				orderhtml += '<span class="myproduct_price'+singlecount+'"><input type="text" name="product_price[]" id="product_price'+singlecount+'" class="form-control singleproduct_price" readonly="readonly"/></span>';
				orderhtml += '</div></div>';
				orderhtml += '<div class="col-md-1"><div class="form-group"><label>Remove</label>';
				orderhtml += '<button type="button" name="remove" id="'+singlecount+'" class="btn btn-danger btn-xs remove"><i class="fa fa-trash"></i></button>';
				orderhtml += '</div></div>';
				$('#action_prosingle').attr('disabled',false);
				$('#action_prosingle').val('Add Order');
				$('#btn_action_prosingle').val('AddOrder');
			}
			orderhtml += '</div></span>';
			$('.span_singleproduct_details').append(orderhtml);
			$('.selectpicker').selectpicker('refresh');
		}
		var singlecount = 0;
		$(document).on('click', '#add_moresingle', function(){
			singlecount++ ;
			add_singleproduct_row(singlecount);
			if( ($('#singlediscount').val() == '') && ($('#singlediscount').val() < 1) ){
				$('#singlediscount').val('0');
			}
			$('#singlediscount').prop('readonly',false);
		});
		
		$(document).on('click', '.remove', function(){
			var row_no = $(this).attr("id");
			$('#row'+row_no).remove();
			cal_total();
			cal_edittotal();
			cal_singletotal();
		});
		function cal_total2(){
			var sum = 0;
			$('.quantitys').each(function(){
				var id = $(this).attr('id');
				id = id.replace("quantitys",'');
				var price = $('#service_id'+id).find(':selected').attr('data-price') ;
				var quantity  = $('#quantitys'+id).val();
				var discount = $('#discounts').val();
                 price = parseFloat(price.replace(/,/g, ''));
              //  alert(id+'//'+price+'/'+quantity+'/'+discount);
                
				if(!discount || discount < 0 || discount > 100) {
					discount = 0;
					$('#discounts').val('0');
				}
				if(!quantity || quantity < 1) {
					quantity = 1;
					$('#quantitys'+id).val('1');
				} 
				var total = (price-(price * (discount/100)))*quantity;
                
                //alert(id+'//'+price+'/'+quantity+'/'+discount);
                
				$('#service_price'+id).val(total);
				sum += total ;
			});
			$('#totalAftertax2').val(sum);
		    $('#dues2').val(sum.toFixed(2)) ;
		}
    
    
    
    function cal_total(){
			var sum = 0;
			$('.quantity').each(function(){
				var id = $(this).attr('id');
				id = id.replace("quantity",'');
				var price = $('#product_id'+id).find(':selected').attr('data-price') ;
				var quantity  = $('#quantity'+id).val();
				var discount = $('#discount').val();
				if(!discount || discount < 0 || discount > 100) {
					discount = 0;
					$('#discount').val('0');
				}
				if(!quantity || quantity < 1) {
					quantity = 1;
					$('#quantity'+id).val('1');
				} 
				var total = (price-(price * (discount/100)))*quantity;
				$('#product_price'+id).val(total);
				sum += total ;
			});
			$('#totalAftertax').val(sum);
		    $('#due').val(sum.toFixed(2)) ;
		}
    
    
		function cal_edittotal(){
			var editsum = 0;
			$('.editquantity').each(function(){
				var id = $(this).attr('id');
				id = id.replace("quantity",'');
				var price = $('#product_id'+id).find(':selected').attr('data-price') ;
				var quantity  = $('#quantity'+id).val();
				var discount = $('#editdiscount').val();
				if(!discount || discount < 0 || discount > 100) {
					discount = 0;
					$('#editdiscount').val('0');
				}
				if(!quantity || quantity < 1) {
					quantity = 1;
					$('#quantity'+id).val('1');
				} 
				var total = (price-(price * (discount/100)))*quantity;
				$('#product_price'+id).val(total);
				editsum += total ;
			});
			var due_amt = editsum - $('#editpaid').val() ;
			$('#edittotalAftertax').val(editsum);
		    $('#editdue').val(due_amt.toFixed(2)) ;
		}
		function cal_singletotal(){
			var singlesum = 0;
			$('.singlequantity').each(function(){
				var id = $(this).attr('id');
				id = id.replace("quantity",'');
				var price = $('#product_id'+id).find(':selected').attr('data-price') ;
				var quantity  = $('#quantity'+id).val();
				var discount = $('#singlediscount').val();
				if(!discount || discount < 0 || discount > 100) {
					discount = 0;
					$('#singlediscount').val('0');
				}
				if(!quantity || quantity < 1) {
					quantity = 1;
					$('#quantity'+id).val('1');
				} 
				var total = (price-(price * (discount/100)))*quantity;
				$('#product_price'+id).val(total);
				singlesum += total ;
			});
			var singledue_amt = singlesum - $('#singlepaid').val() ;
			$('#singletotalAftertax').val(singlesum);
		    $('#singledue').val(singledue_amt.toFixed(2)) ;
		}
		
    
    $(document).on('change',"#discount2", function(){
		 cal_total2();											
		});
    
       $(document).on('change',"#discount", function(){
		 cal_total();											
		});
		$(document).on('change',"#editdiscount", function(){
		 cal_edittotal();											
		});
		$(document).on('change',"#singlediscount", function(){
		 cal_singletotal();											
		});
		
    

        $(document).on('change',"#paid2", function(){
		 var due_amount = ( $('#totalAftertax2').val() - $('#paid2').val() )	;
		 if(due_amount < 0){
			 $('#paid2').val('0');
			 $('#due2').val($('#totalAftertax2').val());
		 } else {
			 $('#due2').val(due_amount.toFixed(2));
		 }
		});
    
    
    
    $(document).on('change',"#paid", function(){
		 var due_amount = ( $('#totalAftertax').val() - $('#paid').val() )	;
		 if(due_amount < 0){
			 $('#paid').val('0');
			 $('#due').val($('#totalAftertax').val());
		 } else {
			 $('#due').val(due_amount.toFixed(2));
		 }
		});
    
    
    
    
		$(document).on('change',"#editpaid", function(){
		 var due_amount = ( $('#edittotalAftertax').val() - $('#editpaid').val() )	;
		 if(due_amount < 0){
			 $('#editpaid').val('0');
			 $('#editdue').val($('#edittotalAftertax').val());
		 } else {
			 $('#editdue').val(due_amount.toFixed(2));
		 }
		});
		$(document).on('change',"#singlepaid", function(){
		 var due_amount = ( $('#singletotalAftertax').val() - $('#singlepaid').val() )	;
		 if(due_amount < 0){
			 $('#singlepaid').val('0');
			 $('#singledue').val($('#singletotalAftertax').val());
		 } else {
			 $('#singledue').val(due_amount.toFixed(2));
		 }
		});
	
    
    	$(document).on('change',".service_id", function(){
			var row_no = $(this).attr("id");
			row_no = row_no.replace("service_id",'');
			$('#service_price'+row_no).val('');
			$('#quantitys'+row_no).val('');
			cal_total2();
		});
    
    $(document).on('change',".product_id", function(){
			var row_no = $(this).attr("id");
			row_no = row_no.replace("product_id",'');
			$('#product_price'+row_no).val('');
			$('#quantity'+row_no).val('');
			cal_total();
		});
		$(document).on('change',".editproduct_id", function(){
			var row_no = $(this).attr("id");
			row_no = row_no.replace("product_id",'');
			$('#product_price'+row_no).val('');
			$('#quantity'+row_no).val('');
			cal_edittotal();
		});
		$(document).on('change',".singleproduct_id", function(){
			var row_no = $(this).attr("id");
			row_no = row_no.replace("product_id",'');
			$('#product_price'+row_no).val('');
			$('#quantity'+row_no).val('');
			cal_singletotal();
		});
		
    
    
    $(document).on('change',".quantitys", function(){
			cal_total2();
		});
    
    
    $(document).on('change',".quantity", function(){
			cal_total();
		});
		$(document).on('change',".editquantity", function(){
			cal_edittotal();
		});
		$(document).on('change',".singlequantity", function(){
			cal_singletotal();
		});
		$(document).on('change',"#ordercustomer_username", function(){
			fetch_username();
		});
		function fetch_username(){
			var username = $('#ordercustomer_username').find(':selected').val() ;
			var btn_action_pro = 'fetch_username';
			$.ajax({
				url: base_url+"add_headerorder_action.php",
				method:"POST",
				data:{username:username, btn_action_pro:btn_action_pro},
				dataType:"json",
				success:function(data)
				{	
					$('#ordercustomer_name').val(data.customer_name);
					$('#ordercustomer_email').val(data.customer_email);
					$('#ordercustomer_mobile').val(data.customer_mobile);
					$('#ordercustomer_tax').val(data.customer_tax);
					$('#ordercustomer_id').val(username);
					
				}
			});
		}
    
    
    
    
    
    function fetch_username(){
        
        //alert("debug");
			var username = $('#orderemployee_username').find(':selected').val() ;
			var btn_action_pro = 'fetch_username';
			$.ajax({
				url: base_url+"add_headerorder_action2.php",
				method:"POST",
				data:{username:username, btn_action_pro:btn_action_pro},
				dataType:"json",
				success:function(data)
				{	
					$('#orderemployee_name').val(data.customer_name);
					$('#orderemployee_email').val(data.customer_email);
					$('#orderemployee_mobile').val(data.customer_mobile);
					$('#orderemployee_tax').val(data.customer_tax);
					///$('#orderemployee_tax').val(data.customer_tax);
					//$('#orderemployee_tax').val(data.customer_tax);
					$('#orderemployee_id').val(username);
					
				}
			});
		}
    
    
    
    
    
		$(document).on('submit','#headerorder_form2', function(event){
		event.preventDefault();
		$('#action_pro').attr('disabled','disabled');
		var form_data = $(this).serialize();
			$.ajax({
				url: base_url+"add_order_action2.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#headerorder_form2')[0].reset();
					$('#headerorderModal2').modal('hide');
					$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
							setTimeout(function(){
								$(".remove-messages").fadeOut("slow");
							},2000);
					$('#action_pro').attr('disabled', false);
					manageOrderTable.ajax.reload();
				}
			})
		});
    
    
		$(document).on('submit','#headerorder_form', function(event){
		event.preventDefault();
		$('#action_pro').attr('disabled','disabled');
		var form_data = $(this).serialize();
			$.ajax({
				url: base_url+"add_order_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#headerorder_form')[0].reset();
					$('#headerorderModal').modal('hide');
					$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
							setTimeout(function(){
								$(".remove-messages").fadeOut("slow");
							},2000);
					$('#action_pro').attr('disabled', false);
					manageOrderTable.ajax.reload();
				}
			})
		});
    
    
		$(document).on('submit','#editorder_form', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
			$.ajax({
				url: base_url+"add_order_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#editorder_form')[0].reset();
					$('#editorderModal').modal('hide');
					$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
							setTimeout(function(){
								$(".remove-messages").fadeOut("slow");
							},2000);
					$('.action_pro').attr('disabled', false);
					manageOrderTable.ajax.reload();
				}
			})
		});
		$(document).on('submit','#singleorder_form', function(event){
		event.preventDefault();
		$('#action_prosingle').attr('disabled','disabled');
		var form_data = $(this).serialize();
			$.ajax({
				url: base_url+"add_singleorder_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#singleorder_form')[0].reset();
					$('#singleorderModal').modal('hide');
					$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
							setTimeout(function(){
								$(".remove-messages").fadeOut("slow");
							},2000);
					$('#action_prosingle').attr('disabled', false);
					manageCustomerTable.ajax.reload();
				}
			})
		});
	$(document).on('click', '.changeOrderStatus', function(){
			var orderId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "changeOrderStatus";
			if(confirm("Are you sure you want to change Order status?"))
			{
				$.ajax({
					url: base_url+"change_order_status.php",
					method:"POST",
					data:{orderId:orderId, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						manageOrderTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	$(document).on('click', '.pendingBalance', function(){												
		var orderId = $(this).attr("id");
		var btn_action_pro = 'fetch_due_amount';
		$('#dueamount_form')[0].reset();
		$.ajax({
			url: base_url+"add_order_action.php",
			method:"POST",
			data:{orderId:orderId, btn_action_pro:btn_action_pro},
			dataType:"json",
			success:function(data)
			{	
				$('#dueamountModal').modal('show');
				$('#dueamount').val(data.order_due_amount);
				$('#dueorder_id').val(data.order_id);
				$('#order_totalamt').val(data.order_total);
				$('#action_pro_dueamt').val('Clear Due Amount');
				$('#btn_actionpro_dueamt').val('ClearDueAmount');
			}
		})
	});
	$(document).on('submit','#dueamount_form', function(event){
		event.preventDefault();
		$('#action_pro_dueamt').attr('disabled','disabled');
		var form_data = $(this).serialize();
			$.ajax({
				url: base_url+"add_order_action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#dueamount_form')[0].reset();
					$('#dueamountModal').modal('hide');
					$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
							setTimeout(function(){
								$(".remove-messages").fadeOut("slow");
							},2000);
					$('#action_pro_dueamt').attr('disabled', false);
					manageOrderTable.ajax.reload();
				}
			})
		});
    
    
    
    
    
    
    
    
    
    
    
    
    
	var manageDateWiseSale = $('#manageDateWiseSale').DataTable();
	var manageDateWiseSaletwo = $('#manageDateWiseSaletwo').DataTable();
	var manageproductwiseSale = $('#manageproductwiseSale').DataTable();
	var managecategorywiseSale = $('#managecategorywiseSale').DataTable();
	$(document).on('submit','#datewiseSale_form', function(event){
		event.preventDefault();
		$('#datewise_action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"fetchDatewiseSale.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('.datewiseSale').show('slow');
				$('#datewise_action').attr('disabled', false);
				data = JSON.parse(data);
				manageDateWiseSale.clear().draw();
				manageDateWiseSale.rows.add(data.data).draw();
				manageDateWiseSaletwo.clear().draw();
				manageDateWiseSaletwo.rows.add(data.datatwo).draw();
			}
		})
	});
	$(document).on('submit','#productwiseSale_form', function(event){
		event.preventDefault();
		$('#productwise_action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"fetchProductwiseSale.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('.productwiseSale').show('slow');
				$('#productwise_action').attr('disabled', false);
				data = JSON.parse(data);
				manageproductwiseSale.clear().draw();
				manageproductwiseSale.rows.add(data.data).draw();
			}
		})
	});
	$(document).on('submit','#categorywiseSale_form', function(event){
		event.preventDefault();
		$('#categorywise_action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"fetchCategorywiseSale.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('.categorywiseSale').show('slow');
				$('#categorywise_action').attr('disabled', false);
				data = JSON.parse(data);
				managecategorywiseSale.clear().draw();
				managecategorywiseSale.rows.add(data.data).draw();
			}
		})
	});
	$(document).on('submit','.company_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_company_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
				$('#companyname').val(data.name);
				$('#companyemail').val(data.email);
				$('#companyphone').html(data.phone);
				$('#companytax').html(data.tax);
			}
		})
	});
	$(document).ready(function(){
		$('.order_date').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			orientation: "top"
		});
		$('.currency_selectpicker').selectpicker("refresh") ;
	});
	$(document).on('submit','.password_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_password_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#password_validation')[0].reset();
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
			}
		})
	});
	$('#changepassModal').modal('show');
	$(document).on('submit','#changepass_form', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_userpassword_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#changepass_form')[0].reset();
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
			}
		})
	});
	$(document).on('submit','.userpassword_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_changeuserpassword_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('.userpassword_validation')[0].reset();
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
			}
		})
	});
    
});



