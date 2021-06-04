<?php

$control = new control();
//$client_name = $control->post_paid_customer_data();
$client_name = $control->all_customer_data();
$service_type = $control->mushok_service_type();
$fetch_mushok_id = $control->fetch_mushok_id('tbl_mushak_info','mushak_invoice_id');
$prev_mushok_id  = $fetch_mushok_id['prev_mushok_id'];
$next_mushok_id  = $fetch_mushok_id['next_mushok_id'];
$all_month = array(date('m')=>date('F'));
$years = array(date('Y'));

/** in-case of previous month/year entry */
//$all_month = array((date('m')-1)=>date('F',strtotime("previous month")), date('m')=>date('F'));
//$years = array(date('Y') -1, date('Y'));

if (isset($_POST['submit']))
{
    $employee_id    = $_POST['employee_id'];
    $client_id      = $_POST['select_client_name'];
    $mushok_id      = $_POST['mushok_challan_id'];
    $selected_month = $_POST['select_month'];
    $selected_year  = $_POST['select_year'];
    $service_type_id= $_POST['select_service_type'];
    $selected_date  = $selected_year."-".$selected_month."-01"; // mimic like invoice date
    $service_amount   = $_POST['amount'];
    $delivery_unit    = $_POST['delivery_unit'];
    $total_amount     = $_POST['total_value'];
    $supplement_tax   = $_POST['supplement_tax'];
    $exact_vat_amount = $_POST['exact_vat_amount'];
    $vat_percent = $_POST['vat_percentage'];
    $full_amount = $_POST['full_amount'];
    $unit_price  = $_POST['unit_price'];
    $issue_date  = $_POST['issued_date'];
    $selected_date_2  = $selected_year."-".$selected_month;

    $service_description = $_POST['service_name'];
    $service_input  = $_POST['service_name_input'];

    if($service_description == 'other') {
        $service_name = $service_input;
    }
    else {
        $service_name = $service_description;
    }


    $track_id_data = array(
        'client_id' => $client_id,
        'invoice_date' => $selected_date_2,
        'mushok_challan_number' => $mushok_id
    );

//    $challan_exists_chk_data = array(
//        'client_id' => $client_id,
//        'invoice_date' => $selected_date
//    );


    $compose_trk_id = $control->make_track_id($track_id_data);

    //echo $compose_trk_id; exit;
    //check -> a service wise monthly mushok already exists
    //$mushok_exists  = $control->verify_mushok_track_id($challan_exists_chk_data);

    // hold post data for insertion
    $user_mushok_data = array($client_id,$selected_date,$mushok_id,$issue_date,$service_name,$service_amount,$unit_price,$total_amount,$vat_percent,$exact_vat_amount,$full_amount,$supplement_tax,$employee_id,$delivery_unit,$compose_trk_id,$service_type_id);

//    if (!$mushok_exists) {

        // verify if given mushok id already exists for current fiscal year
        $check_mushok_id = $control->mushok_id_verify($mushok_id);

        if (!$check_mushok_id) {
            $record_special_mushok_info = $control->create_mushok_info_record($user_mushok_data);

            if ($record_special_mushok_info) {

                ?>
                <div class="row">
                    <span class="label label-success">Mushok Creation Sucessful.</span>
                </div>
                <br>
                <button class="btn btn-primary" onclick="viewSearch()">View</button>
                <?php
            } else {
                ?>
                <div class="row">
                    <span class="label label-danger">Sorry! mushok creation failed.</span>
                </div>
                <br>
                <button class="btn btn-primary" onclick="getSearch()">Create</button>

                <?php

            }
        }
        else
        {
            ?>
            <div class="row">
                <span class="label label-danger">Oops! This Mushok challan Number already exists.</span>
            </div>
            <br>
            <button class="btn btn-primary" onclick="getSearch()">Try Again</button>
            <?php
        }
    //} // verify month wise single mushok check
    
//    else
//    {
//        ?>
<!--        <div class="row">-->
<!--            <span class="label label-danger">Oops! This Mushok challan has already been created.</span>-->
<!--        </div>-->
<!--        <br>-->
<!--        <button class="btn btn-primary" onclick="getSearch()">Try Again</button>-->
<!--        --><?php
//    }

}
else
{
    ?>

    <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="box box-info">

                    <div class="box-header with-border">
                        <h3 class="box-title">Create মূসক ৬.৩ (Manual Invoice)</h3>
                        <div class="box-tools pull-right">
                        <!-- <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->

                    <div class="box-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="text-center">ক্রেতার নাম :</label>
<!--                                    <select class="form-control" name="select_client_name" id="select_client_name" oninput="getService()" required>-->
                                    <select class="form-control selectpicker" data-live-search="true" name="select_client_name" id="select_client_name" onchange="getService()" required>
                                        <option value="">-Select-</option>
                                        <?php foreach($client_name as $name1): ?>
                                            <option value="<?php echo $name1[1]; ?>"><?php echo $name1['client_name']." (".$name1['ClientBilling'].")"; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ইস্যুর তারিখ :</label>
                                    <input name="issued_date" id="issued_date" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>পূর্ববর্তী চালান নম্বর :</label>
                                        <input name="prev_mushok_challan_id" id="prev_mushok_challan_id" class="form-control" placeholder="<?php echo $prev_mushok_id; ?>"  readonly>
                                    </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>মূসক চালান নম্বর :</label>
                                    <input type="number" name="mushok_challan_id" id="mushok_challan_id" class="form-control" value="<?php echo $next_mushok_id; ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>মাস :</label>
                                    <select name="select_month" id="select_month" class="form-control" required>
                                        <option value="">-Select-</option>
                                        <?php foreach($all_month as $mn => $month): ?>
                                            <option value="<?php echo $mn; ?>"><?php echo $month; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>বছর :</label>
                                    <select name="select_year" id="select_year" class="form-control" required>
                                        <option value="">-Select-</option>
                                        <?php foreach($years as $year): ?>
                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>সেবার ধরণ:</label>
                                    <select name="select_service_type" id="select_service_type" class="form-control" required>
                                        <option value="">-Select-</option>
                                    </select>
                                </div>
                            </div>

<!--                            <div class="col-sm-6">-->
<!--                                <div class="form-group">-->
<!--                                    <label>পণ্য বা সেবার বর্ণনা :</label>-->
<!--                                    <textarea name="service_name" id="service_name" class="form-control" placeholder="--><?php //echo "example: Monthly Charge"; ?><!--" maxlength="151" oninput="inputWarning()" ></textarea>-->
<!--                                    <span class="text-danger" id="service_limit"></span>-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>পণ্য বা সেবার বর্ণনা :</label>
                                    <select name="service_name" id="service_name" class="form-control" oninput="inputField()" required>
                                        <option value="Monthly Charge (NTTN)">Monthly Charge (NTTN)</option>
                                        <option value="Monthly Charge">Monthly Charge</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div id="input_service" style="display: none;">
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <textarea name="service_name_input" id="service_name_input" class="form-control" height="15px" placeholder="<?php echo "example: Monthly Charge ... "; ?>" maxlength="151" oninput="inputWarning()" ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>পরিমাণ :</label>
                                    <input type="number" name="amount" id="amount" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>সরবরাহের একক :</label>
                                    <input type="text" name="delivery_unit" id="delivery_unit" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>একক মূল্য :</label>
                                    <input type="text" name="unit_price" id="unit_price" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>সম্পূরক শুল্কের পরিমাণ :</label>
                                    <input type="text" name="supplement_tax" id="supplement_tax" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>সকল প্রকার শুল্ক ও করসহ মূল্য :</label>
                                    <input type="text" name="full_amount" id="full_amount" class="form-control" oninput="generateAmounts()" required>
                                    <br>
                                    <span id="similar_warning" class="blink label label-warning"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>মূল্য সংযোজন করের হার / সুনির্দিষ্ট কর :</label>
                                    <input type="number" name="vat_percentage" id="vat_percentage" class="form-control" value="5" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>মোট মূল্য :</label>
                                    <input type="text" name="total_value" id="total_value" class="form-control"  readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>মূল্য সংযোজন কর / সুনির্দিষ্ট কর এর পরিমাণ :</label>
                                    <input type="text" name="exact_vat_amount" id="exact_vat_amount" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="hidden" name="employee_id" id="employee_id" class="form-control" value="<?php echo $_SESSION['eID']; ?>" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="text-center">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger" name="submit">Generate</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </form>

    <?php
}
?>

<script type="application/javascript">
    function getSearch() {
        window.location.href = '?l=rate&rel=create_mushok';
    }

    function viewSearch() {
        window.location.href = '?l=musak&rel=view_musak_challan';
    }
</script>

<script type="text/javascript">

    function generateAmounts() {
        var full_amount = document.getElementById('full_amount').value;

        var total_value = Math.round((full_amount / 1.05) * 100) / 100;
        document.getElementById('total_value').value = total_value;

        var exact_vat = Math.round((parseFloat(full_amount) - parseFloat(total_value)) * 100) / 100;
        document.getElementById('exact_vat_amount').value = exact_vat;

        // check for 'Warning Message'
        var clientID  = document.getElementById('select_client_name').value;
        // get current date
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;

        if (clientID !== "" && full_amount!= "" && full_amount!= 0) {

            $.post("./view/warning_msg.php",
                {
                    data: {client:clientID, issue_date:today, amount:full_amount}
                },
                function(data){
                    if (data == "has_similar"){
                        $('#similar_warning').html("Warning!! Mushok with this exact amount already created Today!");
                    } else {
                        $('#similar_warning').html("");
                    }
                });
        }
    }

    function inputWarning() {
        var inputText   = document.getElementById('service_name').value;
        var text_length = inputText.length;
        if (text_length > 150)
        {
            document.getElementById('service_limit').innerHTML = "Warning: Can not exceed maximum 150 characters limit."
        }
    }

    function inputField() {
        var Input = document.getElementById('service_name').value;

        if (Input == 'other')
        {
            $("#input_service").show();
        }
        else
        {
            $("#input_service").hide();
        }
    }

    function getService() {

        // get reference to select element
        var select = document.getElementById('select_service_type');
        // resetting select box
        select.options.length = 1;

        $.post("./view/clientwise_service_type.php",
            {
                data: document.getElementById('select_client_name').value
            },
            function(data, status){

                for(eachIndex in data) {
                    $.each(data[Object.keys(data)[eachIndex]], function (key, value) {
                        //new Option(text, value, defaultSelected, selected)
                        select.options[select.options.length] = new Option(value, key);
                    });
                }

                 //console.log(data);

                // //create new option element
                // var opt = document.createElement('option');
                // // create text node to add to option element (opt)
                // opt.appendChild(document.createTextNode(value));
                // // set value property of opt
                // opt.value = key;
                // // add opt to end of select box (sel)
                // select.appendChild(opt);

                // var keys = Object.keys(data);
                // var i = keys.length;
                // console.table(data);

            },'json');

    }

</script>