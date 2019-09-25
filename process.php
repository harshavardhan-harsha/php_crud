<?php
$name   = $address   = '';
$update = false;
$id     = 0;
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'phpcrud') or die(mysqli_error($mysqli));

if (isset($_POST['add'])) {
 $name    = $_POST['name'];
 $address = $_POST['address'];
 $mysqli->query("INSERT INTO contacts (name,address) VALUES('$name','$address')") or die($mysqli->error);
 $_SESSION['message']  = 'Record has been added!!';
 $_SESSION['msg-type'] = 'success';
 header("location:index.php");
}

if (isset($_GET['delete'])) {
 $id = $_GET['delete'];
 $mysqli->query("DELETE from contacts where id=$id") or die($mysqli->error);
 $_SESSION['message']  = 'Record has been deleted!!';
 $_SESSION['msg-type'] = 'danger';
 header("location:index.php");
}

if (isset($_GET['edit'])) {
 $id         = $_GET['edit'];
 $editResult = $mysqli->query("SELECT * from contacts where id=$id") or die($mysqli->error);
 if ($editResult) {
  $row     = $editResult->fetch_assoc();
  $name    = $row['name'];
  $address = $row['address'];
  $update  = true;
 }
}

if (isset($_POST['update'])) {
 $id      = $_POST['id'];
 $name    = $_POST['name'];
 $address = $_POST['address'];
 $mysqli->query("UPDATE contacts SET name='$name' , address='$address' where id=$id ") or die($mysqli->error);
 $_SESSION['message']  = 'Record updated';
 $_SESSION['msg-type'] = 'success';
 header("location: index.php");
}

// * Export HTML Table data to PDF using TCPDF in PHP
if (isset($_POST["create_pdf"])) {
 require_once 'tcpdf/tcpdf.php';
 $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 $obj_pdf->SetCreator(PDF_CREATOR);
 $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");
 $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
 $obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
 $obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 $obj_pdf->SetDefaultMonospacedFont('helvetica');
 $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
 $obj_pdf->setPrintHeader(false);
 $obj_pdf->setPrintFooter(false);
 $obj_pdf->SetAutoPageBreak(true, 10);
 $obj_pdf->SetFont('helvetica', '', 12);
 $obj_pdf->AddPage();
 $content = '';
 $content .= '
      <h3 align="center">Export HTML Table data to PDF using TCPDF in PHP</h3><br /><br />
      <table border="1" cellspacing="0" cellpadding="5">
           <tr>
                <th width="10%">ID</th>
                <th width="45%">Name</th>
                <th width="45%">Address</th>
           </tr>
      ';
 $result = $mysqli->query("SELECT * FROM contacts ORDER BY id ASC") or die($mysqli->error);

 $output = '';
 while ($row = $result->fetch_assoc()) {
  $output .= '
                <tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['address'] . '</td>
                </tr>
             ';
 }
 $content .= $output;
 $content .= '</table>';
 $obj_pdf->writeHTML($content);
 $obj_pdf->Output('sample.pdf', 'I');
}
