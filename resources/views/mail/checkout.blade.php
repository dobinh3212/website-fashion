<table cellpadding="0" role="presentation">
    <tbody>
    <tr>
        <td>
            <div style="padding-top:0px">
                <div style="color:#0f146d;text-align:center">
                    Cám ơn bạn đã đặt
                    hàng tại FASHION
                </div>
                <div>
                    <h2>Xin chào {{ $name }}</h2>
                    <div>
                    </div>
                    <p>FASHION đã nhận
                        được yêu cầu đặt
                        hàng của bạn và
                        đang xử lý nhé.
                        Bạn sẽ nhận được
                        thông báo tiếp
                        theo khi đơn
                        hàng đã sẵn sàng
                        được giao.</p>
                    <div align="center" style="padding-top:10px">
                        <div>
                            <a>
                                <img src="https://ci3.googleusercontent.com/proxy/rgGaVkpBC9y2CURSeRFSROpS0ByC4Qq9V3vEt6gen2zTZT5x7XjzIh6-Nz1fBJL3KO4LuV4wqLRNzL1p6JoWmoesROrsDCpTRJkgC18DtOyZAwnUd0yv_QqTxnF_4Qy1Ft_cQiwB-vTCLg=s0-d-e1-ft#http://static.cdn.responsys.net/i5/responsysimages/content/Laravel+Pro/btn_TrackOrder_vn.jpg"
                                     style="max-width:300px" border="0" class="CToWUd">
                            </a>
                        </div>
                    </div>

                    <p><b>*Lưu ý nhỏ cho bạn:</b> Bạn chỉ nên nhận hàng khi trạng thái đơn hàng là “<b>Đang giao
                            hàng</b>” và
                        nhớ kiểm tra Mã đơn hàng, Thông tin người gửi và Mã vận đơn để nhận đúng kiện hàng nhé.</p>
                    <ul>


                    </ul>
                </div>
            </div>
            <div>
                <div>
                    Đơn hàng được giao
                    đến</div>
                <div>

                    <table cellpadding="2" cellspacing="0" width="100%">
                        <tbody>
                        <tr>
                            <td width="25%" valign="top" style="color:#0f146d;font-weight:bold">
                                Mã mua hàng *(Có thể tra cứu đơn hàng):
                            </td>
                            <td width="75%" valign="top">
                                {{ $code }}
                            </td>
                        </tr>
                        <tr>
                            <td width="25%" valign="top" style="color:#0f146d;font-weight:bold">
                                Tên:
                            </td>
                            <td width="75%" valign="top">
                                {{ $name }}
                            </td>
                        </tr>

                        <tr>
                            <td valign="top" style="color:#0f146d;font-weight:bold">
                                Địa
                                chỉ
                                nhà:
                            </td>
                            <td valign="top">
                                {{ $address }}
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" style="color:#0f146d;font-weight:bold">
                                Điện
                                thoại:
                            </td>
                            <td valign="top">
                                {{ $phone }}
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" style="color:#0f146d;font-weight:bold">
                                Email:
                            </td>
                            <td valign="top">
                                <a href="mailto:{{ $email }}" target="_blank">{{ $email }}</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>


            <div style="padding-bottom:0px">

                <div>
                    <p style="padding-left:10px;margin-top:0px;margin-bottom:0px;color:#585858">
                        Được bán bởi:   FASHION
                    </p>
                    <div style="border-bottom:0px none">
                        <table cellpadding="0" cellspacing="0" style="width:100%">
                            <tbody>
                            <tr>
                                @foreach (Cart::content() as $item)
                                    <td style="width:60%">
                                        <div>
                                            <a><span style="font-size:14px">{{ $item->name }}</span></a>
                                        </div>
                                        <div>
                                                    <span
                                                        style="font-size:14px">{{ number_format($item->qty*$item->sale, 0, '', '.') }}đ</span>
                                        </div>
                                        <div>
                                            <span style="font-size:14px">Số lượng: {{ $item->qty }}</span>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div style="padding-top:0px">
                <div>
                    <div>
                        <div>
                            <table cellpadding="0" cellspacing="0" style="border-bottom:1px solid #d8d8d8">
                                <tbody>
                                <tr>
                                    <td valign="top" style="color:#585858;width:49%">
                                        Thành
                                        tiền:
                                    </td>
                                    <td align="right" valign="top">
                                        VND
                                    </td>
                                    <td align="right" valign="top">
                                        {{ Cart::subtotal(0, '', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="color:#585858">
                                        Phí
                                        vận
                                        chuyển:
                                    </td>
                                    <td align="right" valign="top">
                                        VND
                                    </td>
                                    <td align="right" valign="top">
                                        0
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="color:#585858">
                                        Tổng
                                        cộng:
                                    </td>
                                    <td align="right" valign="top">
                                        <div style="color:#f27c24;font-weight:bold">
                                            VND
                                        </div>
                                    </td>
                                    <td align="right" valign="top">
                                        <div style="color:#f27c24;font-weight:bold">

                                            {{ Cart::subtotal(0, '', '.') }}
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
                            <table cellpadding="0" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td valign="top" style="color:#585858;width:49%">
                                        Tùy
                                        chọn
                                        vận
                                        chuyển:
                                    </td>
                                    <td align="right" valign="top" colspan="2">
                                        Giao
                                        hàng
                                        Tiêu
                                        chuẩn
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="color:#585858;width:49%">
                                        Hình
                                        thức
                                        thanh
                                        toán:
                                    </td>
                                    <td align="right" valign="top" colspan="2">
                                        Thanh
                                        toán
                                        khi
                                        nhận
                                        hàng
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div>
                <div>
                    Có phải bạn thắc
                    mắc?</div>
                <div>

                    <p>
                        <b>Làm thế nào
                            để thay đổi
                            địa chỉ giao
                            hàng, số
                            điện thoại
                            hoặc thông
                            tin người
                            nhận hàng
                            cho đơn hàng
                            đã đặt?
                        </b><br>
                        Nếu địa thông
                        tin liên lạc/
                        giao hàng chưa
                        chính xác, bạn
                        có thể hủy nếu
                        đơn hàng chưa
                        được chuyển sang
                        trạng thái “Hoàn
                        tất đóng gói” và
                        thử đặt lại đơn
                        hàng mới với
                        thông tin chính
                        xác hơn bạn nhé.
                    </p>
                    <div align="center">
                        <div style="font-size:10px;line-height:20px;height:15px">
                            &nbsp;</div>
                        <a>
                            <div
                                style="background:linear-gradient(45deg,#ff7800 10%,#ff00aa 100%);color:#fff;border-radius:10px;padding:12px 25px!important;display:block!important;text-align:center;text-transform:uppercase;min-width:140px;border-bottom:1px solid #8f8f8f;border-right:1px solid #8f8f8f">
                                NẾU CÒN
                                THẮC
                                MẮC,
                                CLICK
                                TẠI ĐÂY
                                ĐỂ TÌM
                                HIỂU
                                THÊM!
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>
