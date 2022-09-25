<div>
    <nav aria-label="breadcrumb">
        <div class="row">
            <div class="col-2 col-md-1">
                <a href="{{ URL::previous() }}" class="btn btn-warning">Back</a>
            </div>
            <div class="col-10 col-md-9 text-center">
                <h3>Print Barcods</h3>
            </div>

        </div>
    </nav>
    <div class="card">
        <div class="card-body">
            <h5 align="center"><b>Your Sticker looks like</b></h5>

            <div id='DivIdToPrint'>
                <table>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <div
                                    style="v display: grid;margin-left:10px;width: 2.3in;height: 1in;padding: 3px;border-radius: 5px;font-weight: 600;">
                                    <div style="text-align: center;font-size: 12px;">
                                        <b> {{ $item->item_name . '-' . $item->measure . '' . $item->measurement_name }}
                                            <span>
                                                {{ $item->brand_name }}
                                            </span>
                                        </b>
                                    </div>



                                    <div style="margin-left:15px;">
                                        <img style="width: 90%;  height:30%;" src="../barcodes/{{ $item->barcode }}.png"
                                            alt="barcode">

                                    </div>

                                    <div style="text-align: center; font-size: 10px;">
                                        {{ $item->barcode }}
                                    </div>

                                    <div style="text-align: center; font-size: 12px;">
                                        <b> {{ 'Rs.' . number_format($item->sell, 2) }}</b>
                                    </div>

                                    <div style="text-align: center; font-size: 10px;">
                                        <b> {{ 'MFD:' . $item->mfd . '| EXP:' . $item->expiry }}</b>
                                    </div>


                                </div>
                            </td>
                            <td width="25px"></td>
                            <td>
                                <div
                                    style="v display: grid;width: 2.3in;height: 1in;padding: 3px;border-radius: 5px;font-weight: 600;">
                                    <div style="text-align: center;font-size: 12px;">
                                        <b> {{ $item->item_name . '-' . $item->measure . '' . $item->measurement_name }}
                                            <span>
                                                {{ $item->brand_name }}
                                            </span>
                                        </b>
                                    </div>



                                    <div style="margin-left:15px;">
                                        <img style="width: 90%;  height:30%;" src="../barcodes/{{ $item->barcode }}.png"
                                            alt="barcode">

                                    </div>

                                    <div style="text-align: center; font-size: 10px;">
                                        {{ $item->barcode }}
                                    </div>

                                    <div style="text-align: center; font-size: 12px;">
                                        <b> {{ 'Rs.' . number_format($item->sell, 2) }}</b>
                                    </div>

                                    <div style="text-align: center; font-size: 10px;">
                                        <b> {{ 'MFD:' . $item->mfd . '| EXP:' . $item->expiry }}</b>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <br>
            <br>
            <div class="text-right">
                <input type='button' class="btn btn-success" id='btn' value='Print' onclick='printDiv();'>
            </div>
        </div>

    </div>

</div>

<script>
    function printDiv() {

        var divToPrint = document.getElementById('DivIdToPrint');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
        newWin.document.close();
        setTimeout(function() {
        newWin.close();
        }, 10);
    }


    // function printDiv() {
    //     var prtContent = document.getElementById("DivIdToPrint");
    //     var WinPrint = window.open();
    //     WinPrint.document.write(prtContent.innerHTML);
    //     WinPrint.document.close();
    //     WinPrint.focus();
    //     WinPrint.print();
    //     WinPrint.close();
    // }
</script>
