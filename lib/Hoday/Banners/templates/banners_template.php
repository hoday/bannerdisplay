<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">
        ID
      </th>
      <th scope="col">
        Image
      </th>
      <th scope="col">
        Start date
      </th>
      <th scope="col">
        End date
      </th>
      <th scope="col">
        Allowed ips
      </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($banners as $banner): ?>
    <tr>
      <th scope="row">
        <?php echo $banner['banner_id']; ?>
      </th>
      <td>
        <img src="<?php echo $banner['banner_path']; ?>" />
      </td>
      <td>
        <?php echo ($banner['start_date'])->format($formatString); ?>
      </td>
      <td>
        <?php echo ($banner['end_date'])->format($formatString); ?>
      </td>
      <td>
        <?php foreach($banner['allowed_ips'] as $allowed_ip) : ?>
          <div>
            <?php echo $allowed_ip; ?>
          </div>
        <?php endforeach; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
