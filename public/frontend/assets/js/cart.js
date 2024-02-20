$(document).ready(function() {
// Update giỏ hàng
    $(".num-order").change(function() {
        var num_order = $(this).val();
        var subtotal = $(this).attr("data-price");
        var url = $(this).attr("data-url");
        var data = { num_order: num_order, subtotal: subtotal };
        $.ajax({
            url: url,
            method: 'GET',
            data: data,
            dataType: 'json',
            success: function(data) {
                $("#" + data.rowId).text(data.row_total +  "đ");
                $("#total-price span").text(data.cart_total + " VNĐ");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    //Select address
    $('#provinces').on('change', function () {
        let id = $(this).val();

        $('#districts').empty();
        $('#districts').append(`<option value="0" disabled selected>Chọn quận huyện</option>`);
        $.ajax({
            type: 'GET',
            url: "selectAjaxDistrict/"+id,
            success: function (response) {
                var response = JSON.parse(response);
                console.log(response);
                $('#districts').empty();
                $('#districts').append(`<option value="0" disabled selected>Chọn quận huyện *</option>`);
                response.forEach(element => {
                    $('#districts').append(`<option value="${element['id']}">${element['name']}</option>`);
                });
            }
        });
    });
    $('#districts').on('change', function () {
        let id = $(this).val();
        $('#wards').empty();
        $('#wards').append(`<option value="0" disabled selected>Chọn phường xã </option>`);
        $.ajax({
            type: 'GET',
            url: "selectAjaxWard/"+id,
            success: function (response) {
                var response = JSON.parse(response);
                console.log(response);
                $('#wards').empty();
                $('#wards').append(`<option value="0" disabled selected>Chọn phường xã *</option>`);
                response.forEach(element => {
                    $('#wards').append(`<option value="${element['id']}">${element['name']}</option>`);
                });
            }
        });
    });


});
