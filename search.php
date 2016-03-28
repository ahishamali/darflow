<section>
  
    <div class="container">
        
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header"> <i class="glyphicon glyphicon-search"></i> Search result </h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Doc ID</th>
                            <th>Doc Title</th>
                            <th>Date</th>
                            <th>Sender</th>
                            <th>Create by</th>
                            <th>Categories</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result1 as $row) { ?>
                            <tr>
                                <td><?php echo $row['doc_id']; ?></td>
                                <td><?php echo $row['doc_title']; ?></td>
                                <td><?php echo $row['create_on']; ?></td>
                                <td><?php echo $row['sender_name']; ?></td>
                                <td><?php echo $row['create_by']; ?></td>
                                <td><?php echo $cat->get_cat_by_id($row['cat_id']); ?></td>
                            </tr>
                        <?php } ?>
                            <?php foreach ($result2 as $row) { ?>
                            <tr>
                                <td><?php echo $row['doc_id']; ?></td>
                                <td><?php echo $row['doc_title']; ?></td>
                                <td><?php echo $row['create_on']; ?></td>
                                <td><?php echo $row['sender_name']; ?></td>
                                <td><?php echo $row['create_by']; ?></td>
                                <td><?php echo $cat->get_cat_by_id($row['cat_id']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </div>
</section>
