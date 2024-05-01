<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
  <title>WoodCraft</title>

    <!--
    - favicon
  -->
  <link rel="shortcut icon" href="<?php echo ROOT ?>/assets/logo/favicon.ico" type="image/x-icon">

  <!--
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <title>Invoice</title>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo ROOT ?>/assets/css/paymentInvoice.css">
</head>

<body>
    <!-- <?php show($data); ?>
    <?php show($_SESSION['USER_DATA']); ?> -->
    
    <div class="container" style="padding-top: 60px; padding-bottom: 100px;">
        <div class="toolbar hidden-print">
            <div class="card-body text-end">
                <button type="button" class="btn btn-dark" id="printInvoice"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div id="invoice">
                    <div class="invoice overflow-auto">
                        <h1 class="text-center text-gray-light">Invoice</h1>
                        <div style="min-width: 600px">
                            <header>
                                <div class="row">
                                    <div class="col">
                                            <img id="logo" src="<?php echo ROOT; ?>/assets/images/Logo_green.png" data-holder-rendered="true" height="50" style="width: auto;" />
                                    </div>
                                    <div class="col company-details">
                                        <h2 class="name">
                                            <a target="_blank" href="<?php echo ROOT; ?>">
                                                Woodcraft
                                            </a>
                                        </h2>
                                        <div>No.66/A, Kaduwela Road, Battaramulla,</div>
                                        <div>Western, Sri Lanka.</div>
                                        <div>+94 77 123 456</div>
                                        <div>woodcraft.customercare@gmail.com</div>
                                    </div>
                                </div>
                            </header>
                            <main>
                                <div class="row contacts">
                                    <div class="col invoice-to">
                                        <div class="text-gray-light">INVOICE TO:</div>
                                        <h2 class="to"><?= $data['name']; ?></h2>
                                        <div class="address"><?= $data['address']->address_line_1; ?></div>
                                        <div class="address"><?= $data['address']->address_line_2; ?></div>
                                        <div class="address"><?= $data['address']->city; ?></div>
                                        <div class="email"><a href="mailto:" .<?= $_SESSION['USER_DATA']->email; ?>><?= $_SESSION['USER_DATA']->email; ?></a></div>
                                    </div>
                                    <div class="col invoice-details">
                                        <h1 class="invoice-id">Invoice #DS<?= sprintf('%04d', $orderDetails->order_details_id); ?> </h1>
                                        <h4 class="status-badge"><span class="badge bg-success font-size-12 ms-2">Paid</span></h4>
                                        <div class="date">Date of Invoice: <?= date('Y-m-d', strtotime($orderDetails->updated_at)); ?></div>
                                    </div>
                                </div>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">DESCRIPTION</th>
                                            <th class="text-right">UNIT PRICE</th>
                                            <th class="text-right">QANTITY</th>
                                            <th class="text-right">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $subTotal   = 0;
                                        $quantity   = 0;
                                        $delivery_percentage    = 0.15;

                                        foreach ($data['orderItems'] as $key => $orderItem) {
                                            $product = $orderItem->product;
                                            $subTotal += ($product->price)*$orderItem->quantity;
                                            $quantity += $orderItem->quantity;
                                        ?>
                                            <tr>
                                                <td class="no"><?= $key + 1; ?></td>
                                                <td class="text-left">
                                                    <h3><?= $product->name; ?></h3>
                                                    <!-- <?= $product->description; ?> -->
                                                </td>
                                                <td class="unit">Rs.<?= $product->price; ?></td>
                                                <td class="qty"><?= $orderItem->quantity; ?></td>
                                                <td class="total">Rs.<?= $product->price * $orderItem->quantity; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">SUBTOTAL</td>
                                            <td>Rs.<?= number_format($subTotal, 2); ?>.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">DELIVERY</td>
                                            <td>Rs.<?= number_format($delivery_percentage * $subTotal, 2); ?>.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">GRAND TOTAL</td>
                                            <td>Rs.<?= number_format($subTotal + ($delivery_percentage * $subTotal), 2); ?>.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="thanks">Thank you!</div>
                                <div class="notices">
                                    <div>NOTICE:</div>
                                    <div class="notice">For any inquery on purchaise or delivery, contact us via woodcraft.customercare@gmail.com.</div>
                                </div>
                            </main>
                            <div class="invoice-footer">
                                Invoice was created on a computer and is valid without the signature and seal.
                            </div>
                        </div>
                        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#printInvoice').click(function() {
                // Use html2canvas to capture the content of the container
                html2canvas($('.invoice')[0], {
                    scale: 2
                }).then(function(canvas) {
                    var imgData = canvas.toDataURL('image/png');

                    // Initialize jsPDF
                    var pdf = new jspdf.jsPDF('p', 'mm', 'a4');

                    // Add the image to the PDF
                    pdf.addImage(imgData, 'PNG', 10, 20, 190, 200);
                    pdf.setFont('helvetica');
                    pdf.setFontSize(12);

                    // Save or open the PDF
                    pdf.save('invoice.pdf');
                });
            });
        });
    </script>