<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard- Customer Review Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">


        </div>
    </div>

    <h2>Customer Review List</h2>

    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        extract($_POST);

        // 3rd step- clean input


        if (!empty($customername)) {
            $where .= " CustomerName LIKE '%$customername%' AND";
        }

        if (!empty($email)) {
            $where .= " Email LIKE '%$email%' AND";
        }

        if (!empty($date)) {
            $where .= " AddDate LIKE '%$date%' AND";
        }



//        
//        if(!empty($minprice) && !empty($maxprice) ){
//              $where.=" Price BETWEEN '$minprice' AND '$maxprice' AND";
//
//        }
//        


        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = "WHERE $where";
        }
    }
    ?>     

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >

        <div class="row mb-3"> 



            <div class="col">
                <input type="text" class="form-control" placeholder="Customer Name" name="customername">
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="Email" name="email">
            </div>

            <div class="col">
                <input type="date" class="form-control" placeholder="Date" name="date">
            </div>



            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" style="font-size:15px">Search</i> </button>
            </div>



        </div>



    </form>



    <div class="table-responsive mt-4">
        <?php
        $sql = "SELECT * FROM tbl_reviews $where";
        $db = dbConn();
        $result = $db->query($sql);
        ?>

        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Message</th>
                    <th scope="col">Customer Image</th>
                    <th scope="col">Add Date</th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>

                        <tr>
                            <td></td>
                            <td><?= $row['CustomerName'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['Description'] ?></td>
                            <td><img class="img-fluid" width="200" src="../../web2/assets/img/customer/<?= $row['Image'] ?>"></td>
                            <td><?= $row['AddDate'] ?></td>  



                        </tr>

                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>


</main>

<?php include '../footer.php'; ?> 

