var dataList = $("#dataList");
var DatatablesBasic = {
	init:function(){
		dataList.dataTable({
            "scrollX": true,
			processing: true,
			serverSide: true,
			searching: (Globals.dtSearching == false ? Globals.dtSearching : true),
			dom: (Globals.dtDom ? Globals.dtDom : ''),
            buttons: (Globals.dtButtons ? Globals.dtButtons : null),
			ajax: {
				type: "POST",
				headers: {"X-CSRF-TOKEN": Globals.csrf},
				url: Globals.urlList,
			},
            bFilter: true,

			lengthMenu:[5,10,25,50,100,200],
			pageLength:50,
			language:{
				lengthMenu: "Display _MENU_",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
			},
			order:Globals.defaultOrderColumns,
			columnDefs: [
                {
                    "targets": (Globals.hiddenColumns ? Globals.hiddenColumns : null),
                    "visible": false,
                },
				{
					orderable: false,
					targets: Globals.disableOrderColumns
				}, {
					targets: 0 ,
					width: "30px",
					className: "dt-right",
					orderable: false
				}
			],
			fnDrawCallback: function(oSettings) {
				if(parseInt(dataList.fnGetData().length) == 0) {
					$(".buttons-html5").attr("disabled", "disabled");
                    $(".check-all").attr("disabled", "disabled");
				} else {
                    $(".buttons-html5").removeAttr("disabled");
                    $(".check-all").removeAttr("disabled");
				}
                $(".dt-buttons button").removeClass("btn-secondary");
				$(".checkboxes").change(function () {
					if ($('.checkboxes:checked').length == $('.checkboxes').length) {
                        $('.check-all').prop('checked', $(this).prop('checked'));
                    } else if ($('.checkboxes:checked').length != $('.checkboxes').length) {
                        $('.check-all').prop('checked', false);
                    }

                    if($(this).prop("checked")) {
                        dataList.DataTable().rows(":eq(" + $(".checkboxes").index($(this)) + ")").select();
                    } else {
                        dataList.DataTable().rows(":eq(" + $(".checkboxes").index($(this)) + ")").deselect();
                    }
				});

				if(Globals.urlUpdateStatus) {
                    $(".btn-status").click(function () {
                        current = $(this);
                        current.attr("disabled", "disabled");
                        current.find("i").addClass("fa-spin fa-spinner");
                        $.ajax({
                            type: "POST",
                            url: Globals.urlUpdateStatus,
                            headers: {"X-CSRF-TOKEN": Globals.csrf},
                            dataType: "JSON",
                            data: {sid: current.attr("id"), status: (current.attr("status") == "1" ? 0 : 1)},
                            success: function (data) {
                                if (data.updated) {
                                    if (data.status == "1" || data.status == "0") {
                                        current.attr("status", data.status);
                                    }
                                    if (data.status == "0") {
                                        current.removeClass("btn-danger");
                                        current.addClass("btn-success");
                                        current.html('<i class="fa fa-eye"></i>');
                                        $(".record-" + current.attr("id")).html("Deactive");
                                        $(".record-" + current.attr("id")).removeClass("m-badge--success");
                                        $(".record-" + current.attr("id")).addClass("m-badge--danger");
                                        current.attr("data-original-title", "Click to activate");
                                    } else {
                                        current.removeClass("btn-success");
                                        current.addClass("btn-danger");
                                        current.find("i").removeClass("fa-eye");
                                        current.find("i").addClass("fa-eye-slash");
                                        current.html('<i class="fa fa-eye-slash"></i>');
                                        $(".record-" + current.attr("id")).html("Active");
                                        $(".record-" + current.attr("id")).removeClass("m-badge--danger");
                                        $(".record-" + current.attr("id")).addClass("m-badge--success");
                                        current.attr("data-original-title", "Click to deactivate");
                                    }

                                    $(".m-tooltip").remove();
                                }
                            },
                            complete: function () {
                                current.find("i").removeClass("fa-spin fa-spinner");
                                current.removeAttr("disabled");
                            },
                            error: function (data) {
                                // alert("Something went wrong.");
								if (data.status == "503") {
									/*swal({
									    title: "Error",
									    text: "Something went wrong.",
									    type: "error",
									    allowOutsideClick: false,
									    showConfirmButton: true,
									    confirmButtonClass: "btn-danger",
									    confirmButtonText: "OK"
									});*/
									swal({
										type: 'error',
										title: 'Oops...',
										text: 'You don\'t have access to update status',
									})
								}
                            }
                        });
                    });
                }
			}
		})
	}
};

$(document).ready(function(){
	DatatablesBasic.init();
	$('.check-all').click(function () {
		$('.checkboxes').prop('checked', $(this).prop('checked'));
		if($(this).prop("checked")) {
            dataList.DataTable().rows().select();
		} else {
            dataList.DataTable().rows().deselect();
		}
	});
});
function doDelete()
{
	if ($('tbody tr .checkboxes:checked').length > 0) {
		ok = function () {
			$("#frm_list").submit();
		}
		message_box("Confirm", "Are you sure to delete selected records?", "confirm", ok, null);
	} else {
		message_box("Alert", "Please select records to delete.", "alert", null, null);
	}
}