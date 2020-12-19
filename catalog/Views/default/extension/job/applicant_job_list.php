<div class="table-responsive">
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">Job ID</th>
      <th scope="col">Job Name</th>
      <th scope="col">Type</th>
      <th scope="col">Salary</th>
      <th scope="col">Status</th>
      <th scope="col">Date Added</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($jobs as $job) { ?>
    <tr>
      <th scope="row"><?php echo $job['job_id']; ?></th>
      <td><?php echo $job['name']; ?></td>
      <td><?php echo $job['type']; ?></td>
      <td><?php echo $job['salary']; ?></td>
      <td><?php echo $job['status']; ?></td>
      <td><?php echo $job['date_added']; ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>