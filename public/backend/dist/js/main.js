
$(document).ready(function () {
    $('.updateAttributeStatus').click(function () {
        var status = $(this).text();
        var attribute_id = $(this).attr('attribute_id');
        var url = $(this).attr('data-url');
        $.ajax({
            type: 'get',
            url: url,
            data: {status: status, attribute_id: attribute_id},
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#attribute-" + attribute_id).html("<span class='badge bg-info'> Chờ duyệt </span>");
                } else if (resp['status'] == 1) {
                    $("#attribute-" + attribute_id).html("<span class='badge bg-light-blue'> Hiển Thị</span>");
                }

            }, error: function () {
                alert('Lỗi');
            }
        })
    });


    $(".confirmDelete").click(function () {
        var record = $(this).attr('record');
        var recordid = $(this).attr('recordid');
        Swal.fire({
            title: 'Bạn có muốn xóa không ?',
            text: "Bạn sẽ không thể hoàn nguyên điều này ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonText: 'Không',
            cancelButtonColor: "#d33",
            confirmButtonText: 'Đồng ý',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                window.location.href = "/admin/delete-" + record + "/" + recordid;
            }
        });
    });


    var maxField = 8; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '' +
        '<div style="display:flex;padding:5px"> <input class="form-control" style="max-width: 100px;border-radius:5px;" type="text" name="sku[]" value="" placeholder="Mã" required />  <input class="form-control" style="max-width: 100px;margin-left:5px!important;border-radius:5px; " type="text" name="size[]" placeholder="Size " required value=""/>    <input class="form-control" style="max-width: 100px;margin-left:5px!important;border-radius:5px; " type="number" name="price[]" placeholder="Giá"  required value=""/>  <input class="form-control" style="max-width: 100px;margin-left:5px!important;border-radius:5px;" type="number" name="stock[]"  placeholder="Số lượng" required value=""/><a style="max-width: 100px;margin-left:5px!important;" href="javascript:void(0);" class=" btn btn-danger remove_button"> <i class="fa fa-trash"></i>  Xóa </a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
